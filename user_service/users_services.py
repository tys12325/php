
import requests

# Define the URL of the PHP script that returns JSON
url = "http://localhost/JewellerySaleManagementSystem/user_service/user_service_json.php"

# Send a GET request to fetch the JSON response
try:
    response = requests.get(url)
    # Check if the request was successful (HTTP status code 200)
    if response.status_code == 200:
        # Print the JSON response
        print("JSON Data:", response.json())
    else:
        print(f"Failed to retrieve JSON data. Status code: {response.status_code}")
        print("Response text:", response.text)
except requests.exceptions.RequestException as e:
    print(f"Error occurred: {e}")
