from stable_baselines3 import PPO

from stable_baselines3.common.vec_env import DummyVecEnv

from stable_baselines3.common.monitor import Monitor

from src.environment import PricingEnv

import pandas as pd

import os
from src.preprocess import load_and_clean_data
from src.callbacks import DetailedLogCallback


# 1. Load Data

# --- Load and clean data ---

data_path = "data/raw/Online Retail.xlsx"
data = load_and_clean_data(data_path)
data = data.dropna()

data = data[(data['UnitPrice'] > 0) & (data['Quantity'] > 0)].copy()





# 2. Setup Logging

log_dir = "logs/"

os.makedirs(log_dir, exist_ok=True)



# 3. Initialize Env with Monitor

# info_keywords allows us to save the 'price' and 'min_allowed' we put in the info dict

env = PricingEnv(data)

env = Monitor(env, log_dir, info_keywords=("price", "val", "min_allowed"))

env = DummyVecEnv([lambda: env])



# 4. Define Model with Tensorboard

model = PPO(

    "MlpPolicy",

    env,

    verbose=1,

    tensorboard_log=log_dir,

    ent_coef=0.05,  # Slightly lower entropy for faster convergence

    policy_kwargs={"log_std_init": -1.0} # Start with less noise

)



# 5. Train

detailed_logger = DetailedLogCallback(log_dir=log_dir)
#5.000.000
print("🚀 Starting training...")
model.learn(
    total_timesteps=5_000_000, 
    callback=detailed_logger # <--- Add this line
)


# 6. Save

model.save("saved_models/dynamic_model")

print(f"✅ Training complete. Results saved in {log_dir}monitor.csv")