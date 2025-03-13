import requests

def get_invoice():
    url = 'http://localhost/JewellerySaleManagementSystem/serve_invoice.php'
    response = requests.get(url)

    if response.status_code == 200:
        print("Invoice XML retrieved successfully.")
        print(response.text)  # Process or save the XML as needed
    else:
        print(f"Error: {response.status_code} - {response.text}")

if __name__ == "__main__":
    get_invoice()
