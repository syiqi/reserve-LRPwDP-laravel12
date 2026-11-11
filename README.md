Tech Stack:-

Web Application:-
"php": "^8.2",
"laravel/framework": "^12.0",
and more in LRPwDP\composer.json file

Dynamic Pricing Model:-
Flask==3.1.2
gym==0.26.2
gymnasium==1.2.0
holidays==0.79
matplotlib==3.10.5
numpy==2.2.6
opencv-python==4.12.0.88
openpyxl==3.1.5
pandas==2.3.2
python-dotenv==1.1.1
scikit-learn==1.7.1
stable_baselines3==2.7.0
and more in DRL_PPO_Model\requirement.txt

LRPwDP files houses the laravel web application which is used as the reservation platform for sellers to list the perishables and customers to reserve them.
DRL_PPO_Model files contains the Deep Reinforcement's Proximity Policy Optimization machine learning model which is used to dynamically price perishables
by considering multiple internal(timeuntilexpiry,quantityleft,currentPrice) and external factors(weather,dayoftheweek,holidays). The model also uses a OpenWeatherMap API to retrieve a location's weather code.
The system works alongside a MySQL database, where hourly(minutes,second,etc..) triggers made from the Laravel's task scheduling will connect to the Flask's RESTful API which will execute a process for the trained model to set new prices on the available perishable in the database.

