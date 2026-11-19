# src/environment.py
import gymnasium as gym  # Changed from import gym
from gymnasium import spaces
import numpy as np

MAX_PRICE_ESTIMATE = 300.0

class PricingEnv(gym.Env):
    def __init__(self, data):
        self.data = data.reset_index(drop=True)
        self.max_time = 50 
        self.action_space = spaces.Box(low=-1.0, high=1.0, shape=(1,), dtype=np.float32)
        self.observation_space = spaces.Box(low=0.0, high=1.0, shape=(7,), dtype=np.float32)
        self.actions_taken = []
        
    def reset(self, seed=None, options=None):

        super().reset(seed=seed)
        
        self.current_product = self.data.sample(1).iloc[0]
        self.original_price = self.current_product['UnitPrice']
        self.quantity = min(self.current_product['Quantity'] * 4, 150)
        self.remaining_quantity = self.quantity
        self.initial_total_value = self.quantity * self.original_price
        self.step_count = 0
        
        observation = self._get_observation()
        info = {} # Reset also returns an info dict now
        return observation, info

    def _get_observation(self):
        time_left_ratio = 1 - (self.step_count / self.max_time)
        stock_ratio = self.remaining_quantity / self.quantity if self.quantity > 0 else 0.0
        
        return np.array([
            time_left_ratio,
            stock_ratio,
            self.current_product['WeatherCode'] / 6.0,
            self.current_product['Weekday'] / 6.0,
            int(self.current_product['IsHoliday']),
            int(self.current_product['IsHolidaySoon']),
            self.original_price / MAX_PRICE_ESTIMATE,
        ], dtype=np.float32)

    def step(self, action):
        self.actions_taken.append(action[0])
        
        # --- DYNAMIC LOWER BOUND LOGIC ---
        time_left_ratio = 1 - (self.step_count / self.max_time)
        dynamic_min_mult = 0.2 + (0.6 * time_left_ratio) 
        price_multiplier = dynamic_min_mult + (1.0 - dynamic_min_mult) * ((action[0] + 1) / 2)
        new_price = self.original_price * price_multiplier

        # --- Demand Simulation ---
        weather_factor = {1:0.85, 2:0.95, 3:0.9, 4:1.0, 5:1.0, 6:1.0}.get(self.current_product['WeatherCode'], 1.0)
        weekday_factor = 1.15 if self.current_product['Weekday'] in [4, 5, 6] else 1.0
        
        holiday_factor = 1.0
        if self.current_product['IsHoliday']:
            holiday_factor = 1.2  # 20% boost on the day
        elif self.current_product['IsHolidaySoon']:
            holiday_factor = 1.1 # 10% boost leading up to it

        external_factor = weather_factor * weekday_factor * holiday_factor
        
        demand = (1.0 / (1 + np.exp(10 * (price_multiplier - 0.8)))) * external_factor
        sales_ratio = np.clip(demand * np.random.normal(1.0, 0.05), 0, 1)

        units_sold = min(self.remaining_quantity, self.quantity * sales_ratio)
        self.remaining_quantity -= units_sold
        
        # --- Reward Function ---
        revenue = units_sold * new_price
        reward = (0.4 * (revenue / self.initial_total_value) + 
                  0.4 * (units_sold / self.quantity) - 
                  0.2 * (self.remaining_quantity / self.quantity))

        self.step_count += 1
        
        # --- Gymnasium Return Format ---
        terminated = self.remaining_quantity <= 0  # Episode ends naturally
        truncated = self.step_count >= self.max_time  # Episode ends because time limit hit
        
        info = {"price": new_price, "val": revenue, "min_allowed": dynamic_min_mult}
        
        return self._get_observation(), float(reward), terminated, truncated, info