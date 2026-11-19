import os
import csv
import numpy as np
from stable_baselines3.common.callbacks import BaseCallback

class DetailedLogCallback(BaseCallback):
    def __init__(self, log_dir, verbose=0):
        super(DetailedLogCallback, self).__init__(verbose)
        self.log_path = os.path.join(log_dir, "detailed_training_log.csv")
        self.file_handler = None
        self.csv_writer = None

    def _on_training_start(self):
        # Create CSV with headers
        self.file_handler = open(self.log_path, "w", newline="")
        self.csv_writer = csv.writer(self.file_handler)
        self.csv_writer.writerow([
            "episode", "step", "time_left", "stock_ratio", 
            "price_action", "actual_price", "units_sold", "revenue", "reward"
        ])

    def _on_step(self) -> bool:
        # Access the environment info
        # Note: 'infos' is a list (one per env). We assume 1 env here.
        info = self.locals["infos"][0]
        obs = self.locals["new_obs"][0]
        reward = self.locals["rewards"][0]
        
        # Extract meaningful values
        # obs[0] is time_left, obs[1] is stock_ratio (based on your env)
        time_left = obs[0] 
        stock_ratio = obs[1]
        
        # Retrieve values we stashed in 'info' dict in environment.py
        price = info.get("price", 0)
        revenue = info.get("val", 0)
        
        # Log to CSV
        # We need to track episode counts manually or infer from resets, 
        # but for simple analysis, just logging the stream is enough.
        self.csv_writer.writerow([
            self.n_calls,  # Global step count
            self.locals["n_steps"], # Steps in current rollout
            f"{time_left:.4f}",
            f"{stock_ratio:.4f}",
            f"{self.locals['actions'][0][0]:.4f}", # The raw neural net output
            f"{price:.2f}",
            f"{(revenue/price) if price > 0 else 0:.2f}", # Infer units sold
            f"{revenue:.2f}",
            f"{reward:.4f}"
        ])
        return True

    def _on_training_end(self):
        if self.file_handler:
            self.file_handler.close()