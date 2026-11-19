 cd C:\Users\User\FYP\DRL_PPO_Model
venv\Scripts\activate.bat

to open virtual environment again

  test out pricing
:: ----------------------------- 🕒 Expiry Time Variation -----------------------------
echo ==== ExpiryHours Variation ====
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":240,\"Quantity\":30,\"TotalQuantity\":150,\"Weekday\":2,\"city\":\"Kuala Lumpur\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":120,\"Quantity\":30,\"TotalQuantity\":150,\"Weekday\":2,\"city\":\"Kuala Lumpur\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":30,\"TotalQuantity\":150,\"Weekday\":2,\"city\":\"Kuala Lumpur\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":48,\"Quantity\":30,\"TotalQuantity\":150,\"Weekday\":2,\"city\":\"Kuala Lumpur\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":12,\"Quantity\":30,\"TotalQuantity\":150,\"Weekday\":2,\"city\":\"Kuala Lumpur\"}"

:: ----------------------------- 📦 Quantity Variation -----------------------------
echo ==== Quantity Variation ====
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":10,\"TotalQuantity\":150,\"Weekday\":2,\"city\":\"Kuala Lumpur\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":30,\"TotalQuantity\":150,\"Weekday\":2,\"city\":\"Kuala Lumpur\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":70,\"TotalQuantity\":150,\"Weekday\":2,\"city\":\"Kuala Lumpur\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":120,\"TotalQuantity\":150,\"Weekday\":2,\"city\":\"Kuala Lumpur\"}"

:: ----------------------------- 📦 Total Quantity Variation -----------------------------
echo ==== TotalQuantity Variation ====
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":30,\"TotalQuantity\":30,\"Weekday\":2,\"city\":\"Kuala Lumpur\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":30,\"TotalQuantity\":90,\"Weekday\":2,\"city\":\"Kuala Lumpur\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":30,\"TotalQuantity\":150,\"Weekday\":2,\"city\":\"Kuala Lumpur\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":30,\"TotalQuantity\":300,\"Weekday\":2,\"city\":\"Kuala Lumpur\"}"

:: ----------------------------- 📅 Weekday Variation -----------------------------
echo ==== Weekday Variation ====
:: 0 = Monday, ..., 6 = Sunday
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":30,\"TotalQuantity\":150,\"Weekday\":0,\"city\":\"Kuala Lumpur\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":30,\"TotalQuantity\":150,\"Weekday\":2,\"city\":\"Kuala Lumpur\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":30,\"TotalQuantity\":150,\"Weekday\":5,\"city\":\"Kuala Lumpur\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":30,\"TotalQuantity\":150,\"Weekday\":6,\"city\":\"Kuala Lumpur\"}"

:: ----------------------------- 🌆 City (Weather) Variation — Malaysia -----------------------------
echo ==== City (Weather) Variation ====
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":30,\"TotalQuantity\":150,\"Weekday\":2,\"city\":\"Kuala Lumpur\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":30,\"TotalQuantity\":150,\"Weekday\":2,\"city\":\"George Town\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":30,\"TotalQuantity\":150,\"Weekday\":2,\"city\":\"Johor Bahru\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":30,\"TotalQuantity\":150,\"Weekday\":2,\"city\":\"Ipoh\"}"
curl -X POST http://localhost:5000/predict-price -H "Content-Type: application/json" -d "{\"Price\":15.0,\"OriginalPrice\":20.0,\"LowerBound\":10.0,\"ExpiryHours\":72,\"Quantity\":30,\"TotalQuantity\":150,\"Weekday\":2,\"city\":\"Kuching\"}"



  https://archive.ics.uci.edu/dataset/352/online+retail

  data usage