from stable_baselines3 import PPO
from src.environment import PricingEnv
from src.preprocess import load_and_clean_data
import numpy as np
import pandas as pd
import matplotlib.pyplot as plt

data = load_and_clean_data("data/raw/Online Retail.xlsx")
# Apply same preprocessing as in train.py
data = data.dropna()
data = data[(data['UnitPrice'] > 0) & (data['Quantity'] > 0)].copy()
data['ExpiryHours'] = np.random.choice([6, 12, 24, 48, 72, 120], size=len(data))
data['OriginalPrice'] = data['UnitPrice']
data['LowerBound'] = data['UnitPrice'] * np.random.choice([0.1, 0.3, 0.5, 0.7, 1.0], size=len(data))
data['Price'] = data['UnitPrice']
data['WeatherCode'] = np.random.choice([1, 2, 3, 4], size=len(data))
data['Weekday'] = pd.to_datetime(data['InvoiceDate']).dt.weekday
data['IsHoliday'] = np.random.choice([0, 1], size=len(data), p=[0.9, 0.1])
data['IsHolidaySoon'] = np.random.choice([0, 1], size=len(data), p=[0.85, 0.15])

env = PricingEnv(data, external_data=None)
model = PPO.load("saved_models/latest_model")

actions = []
obs = env.reset()
done = False

while not done:
    action, _ = model.predict(obs)
    actions.append(action[0])
    obs, reward, done, _ = env.step(action)

plt.hist(actions, bins=20)
plt.title("Action Distribution (Model Output)")
plt.xlabel("Action (Price Multiplier)")
plt.ylabel("Frequency")
plt.grid()
plt.show()
