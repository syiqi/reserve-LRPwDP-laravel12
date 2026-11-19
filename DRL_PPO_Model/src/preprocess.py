# src/preprocess.py
import pandas as pd
import numpy as np
import holidays

def load_and_clean_data(path):
    print("⏳ Loading data...")
    df = pd.read_excel(path)
    
    # 1. Basic Cleaning
    df = df.dropna(subset=['CustomerID'])
    df = df[(df['Quantity'] > 0) & (df['Quantity'] <= 150)]
    df = df[df['UnitPrice'] > 0]
    df['InvoiceDate'] = pd.to_datetime(df['InvoiceDate'])
    df['TotalPrice'] = df['Quantity'] * df['UnitPrice']
    
    # 2. Feature Engineering
    print("🛠️ Augmenting data with Environment features...")
    
    # A. Weekday (0=Monday, 6=Sunday)
    df['Weekday'] = df['InvoiceDate'].dt.weekday
    
    # B. Holidays
    my_holidays = holidays.Malaysia()
    
    # Create IsHoliday (1 if today is holiday, else 0)
    df['IsHoliday'] = df['InvoiceDate'].dt.date.apply(lambda x: 1 if x in my_holidays else 0)
    
    # Create IsHolidaySoon (1 if holiday is within next 2 days)
    def check_holiday_soon(date_obj):
        return 1 if any((date_obj + pd.Timedelta(days=i)) in my_holidays for i in [1, 2]) else 0
        
    df['IsHolidaySoon'] = df['InvoiceDate'].dt.date.apply(check_holiday_soon)
    
    # C. WeatherCode
    df['WeatherCode'] = np.random.randint(1, 7, size=len(df))
    
    print(f"✅ Data loaded. Shape: {df.shape}")
    return df