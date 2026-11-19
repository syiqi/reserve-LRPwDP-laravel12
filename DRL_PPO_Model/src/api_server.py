from flask import Flask, request, jsonify

from stable_baselines3 import PPO

import numpy as np

import requests

import os

import holidays

from datetime import datetime, timedelta

import csv;



from environment import PricingEnv

from dotenv import load_dotenv

load_dotenv()



OPENWEATHER_API_KEY = os.getenv("OPENWEATHER_API_KEY")



app = Flask(__name__)

model = PPO.load("saved_models/dynamic_model.zip")

LOG_FILE = "inference_history.csv"

# Initialize CSV if not exists
if not os.path.exists(LOG_FILE):
    with open(LOG_FILE, "w", newline="") as f:
        writer = csv.writer(f)
        writer.writerow(["timestamp", "city", "expiry_hours", "stock_ratio", "original_price", "predicted_price"])

#  Map OpenWeather codes to simplified WeatherCode

def map_weather_to_code(weather_main):

    weather_map = {

        "Thunderstorm": 1,

        "Drizzle": 2,

        "Rain": 3,

        "Snow": 4,

        "Clear": 5,

        "Clouds": 6

    }

    return weather_map.get(weather_main, 0)  # 0 = unknown



#  Get real-time weather from OpenWeatherMap

def get_weather_code(city):

    url = f"http://api.openweathermap.org/data/2.5/weather?q={city}&appid={OPENWEATHER_API_KEY}"

    try:

        response = requests.get(url)

        data = response.json()

        if "weather" in data:

            weather_main = data['weather'][0]['main']

            return map_weather_to_code(weather_main)

        else:

            print("⚠️ Weather API error:", data)

            return 0

    except Exception as e:

        print("⚠️ Weather API failed:", e)

        return 0



# 🇲🇾 Check if today or soon is a Malaysian holiday

def get_holiday_flags():

    today = datetime.today().date()

    my_holidays = holidays.Malaysia()

    is_today = today in my_holidays

    is_soon = any((today + timedelta(days=i)) in my_holidays for i in [1, 2])

    return int(is_today), int(is_soon)

    #  FORCED HOLIDAY TESTING

    #  return 0, 0  # is_holiday = False, is_holiday_soon = True

MAX_PRICE_ESTIMATE = 300.0
MAX_LIFESPAN_HOURS = 240.0 # Must match the concept of max_time in training

@app.route("/predict-price", methods=["POST"])

def predict_price():

    data = request.json

        #  Validate required fields

    required_fields = ["ExpiryHours", "Quantity", "TotalQuantity", "OriginalPrice", "LowerBound", "Weekday"]

    for field in required_fields:

        if field not in data:

            return jsonify({"error": f"Missing required field: {field}"}), 400



    if data["TotalQuantity"] == 0:

        return jsonify({"error": "TotalQuantity must be greater than zero"}), 400

   

    #  Get real-time weather for city

    city = data.get("city", "Kuala Lumpur")

    weather_code = get_weather_code(city)



    #  Get holiday flags

    is_holiday, is_holiday_soon = get_holiday_flags()



    remaining_ratio = data['Quantity'] / data['TotalQuantity']



    #  Construct observation

    obs = np.array([
            data['ExpiryHours'] / MAX_LIFESPAN_HOURS,    # Time left ratio
            data['Quantity'] / data['TotalQuantity'],    # Stock ratio
            weather_code / 6.0,
            data['Weekday'] / 6.0,
            is_holiday,
            is_holiday_soon,
            data['OriginalPrice'] / MAX_PRICE_ESTIMATE   # FIX: Matches Env
        ]).reshape(1, -1)





    print("📥 Observation to model:", obs)

    action, _ = model.predict(obs)

    time_left_ratio = data['ExpiryHours'] / MAX_LIFESPAN_HOURS
    dynamic_min_mult = 0.2 + (0.6 * time_left_ratio)
    
    # Map [-1, 1] action to [dynamic_min, 1.0]
    raw_action = float(action[0])
    price_multiplier = dynamic_min_mult + (1.0 - dynamic_min_mult) * ((raw_action + 1) / 2)
    
    new_price = float(np.clip(data['OriginalPrice'] * price_multiplier, data['LowerBound'], data['OriginalPrice']))

    # AFTER calculating new_price, save it:
    with open(LOG_FILE, "a", newline="") as f:
        writer = csv.writer(f)
        writer.writerow([
            datetime.now(),
            city,
            data['ExpiryHours'],
            remaining_ratio,
            data['OriginalPrice'],
            new_price
        ])

    return jsonify({
        "new_price": round(new_price, 2),

        "city": city,

        "weather_code": weather_code,

        "is_holiday": is_holiday,

        "is_holiday_soon": is_holiday_soon,

    })



if __name__ == "__main__":

    app.run(port=5000)