<?php
//Name: SIA YAO QING ID:22WMR13745
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../Models/ProductModel.php';
require_once '../Models/CategoryModel.php';

try {
    // Establish a database connection
    $pdo = new PDO("mysql:host=localhost;dbname=starlightglory", "admin123", "AdminUser@1234");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    $productController = new ProductController($pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json'); // Ensure the response is JSON
        // Start output buffering to avoid any unwanted output that could corrupt JSON response
        ob_start();

        // Collect POST data with existence checks
        $product_ids = isset($_POST['product_id']) ? $_POST['product_id'] : [];
        $names = isset($_POST['name']) ? $_POST['name'] : [];
        $category_ids = isset($_POST['category_id']) ? $_POST['category_id'] : [];
        $new_categories = isset($_POST['new_category']) ? $_POST['new_category'] : [];
        $quantities = isset($_POST['quantity']) ? $_POST['quantity'] : [];
        $weights = isset($_POST['weight']) ? $_POST['weight'] : [];
        $prices = isset($_POST['price']) ? $_POST['price'] : [];
        $descriptions = isset($_POST['description']) ? $_POST['description'] : [];
        $files = isset($_FILES['image']) ? $_FILES['image'] : [];

        // Allowed image MIME types and extensions
        $allowedMIMETypes = ['image/jpeg', 'image/png', 'image/gif'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Handle file uploads and prepare image binary data
        $imageData = [];
        foreach ($files['tmp_name'] as $index => $tmpName) {
            if (!empty($tmpName)) {
                // Get the file extension and MIME type
                $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($fileInfo, $tmpName);
                finfo_close($fileInfo);

                $fileExtension = pathinfo($files['name'][$index], PATHINFO_EXTENSION);

                // Validate the file format (MIME type and extension)
                if (in_array($mimeType, $allowedMIMETypes) && in_array(strtolower($fileExtension), $allowedExtensions)) {
                    // Get the binary data of the image
                    $imageData[$index] = file_get_contents($tmpName);
                } else {
                    echo json_encode(['error' => 'Invalid file format. Only JPG, JPEG, PNG, and GIF formats are allowed.']);
                    exit;
                }
            } else {
                echo json_encode(['error' => 'No image file uploaded.']);
                exit;
            }
        }

        // Call the function to handle adding products
        $response = $productController->addProducts(
                $product_ids, $names, $category_ids, $new_categories,
                $quantities, $weights, $prices, $descriptions, $imageData
        );

        // Flush the output buffer and return response as JSON
        ob_clean(); // Clear any unexpected output
        echo json_encode($response);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
}

class ProductController {

    private $pdo;
    private $productModel;
    private $categoryModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->productModel = new ProductModel($pdo);
        $this->categoryModel = new CategoryModel($pdo);
    }
    
    public function validateInput($data, $files) {
    $errors = [];

    // ProductID validation
    if (empty($data['product_id']) || !preg_match('/^[a-zA-Z0-9]+$/', $data['product_id'])) {
        $errors[] = "Invalid Product ID.";
    }

    // ProductName validation
    if (empty($data['name']) || strlen($data['name']) > 50) {
        $errors[] = "Invalid Product Name.";
    }

    // CategoryID validation
    if (!filter_var($data['category_id'], FILTER_VALIDATE_INT)) {
        $errors[] = "Invalid Category ID.";
    }

    // Quantity validation
    if (!filter_var($data['quantity'], FILTER_VALIDATE_INT) || $data['quantity'] < 1) {
        $errors[] = "Invalid Quantity.";
    }

    // Weight validation
    if (!filter_var($data['weight'], FILTER_VALIDATE_FLOAT) || $data['weight'] <= 0) {
        $errors[] = "Invalid Weight.";
    }

    // Price validation
    if (!filter_var($data['price'], FILTER_VALIDATE_FLOAT) || $data['price'] <= 0) {
        $errors[] = "Invalid Price.";
    }

    // Description validation
    if (strlen($data['description']) > 500) {
        $errors[] = "Description is too long.";
    }

    // Image validation
    $allowedMimeTypes = ['image/jpeg', 'image/png'];
    if (!in_array($files['image']['type'], $allowedMimeTypes) || $files['image']['size'] > 2000000) {
        $errors[] = "Invalid image file.";
    }

    return $errors;
}


    public function addProducts($product_ids, $names, $category_ids, $new_categories, $quantities, $weights, $prices, $descriptions, $imageData) {
    // Loop through each product and validate
    foreach ($product_ids as $index => $product_id) {
        
        // Prepare the data for validation
        $data = [
            'product_id' => $product_id,
            'name' => $names[$index],
            'category_id' => $category_ids[$index],
            'new_category' => $new_categories[$index],
            'quantity' => $quantities[$index],
            'weight' => $weights[$index],
            'price' => $prices[$index],
            'description' => $descriptions[$index]
        ];

        // Simulate file input for validation
        $files = [
            'image' => [
                'type' => $_FILES['image']['type'][$index],  // Assuming $_FILES is used for file upload
                'size' => $_FILES['image']['size'][$index]
            ]
        ];

        // Call the validation function
        $validationErrors = $this->validateInput($data, $files);
        if (!empty($validationErrors)) {
            return ['error' => $validationErrors];
        }

        // Check if category_id is provided, if yes, use it and skip new category logic.
        if (!empty($category_ids[$index])) {
            $category_id = $category_ids[$index];
        } else {
            // If category_id is not provided, handle new category creation.
            if (!empty($new_categories[$index])) {
                $newCategoryName = $new_categories[$index];

                // Check if the category already exists to avoid duplicates
                $existingCategory = $this->categoryModel->getCategoryByName($newCategoryName);
                if ($existingCategory) {
                    $category_id = $existingCategory['CategoryID'];
                } else {
                    // Insert the new category and retrieve the auto-incremented CategoryID
                    if ($this->categoryModel->insertCategory($newCategoryName)) {
                        $category_id = $this->pdo->lastInsertId();  // Get the last inserted CategoryID
                    } else {
                        return ['error' => "Failed to save new category: $newCategoryName"];
                    }
                }
            } else {
                return ['error' => "Neither Category ID nor New Category provided for product ID: $product_id"];
            }
        }

        // Now insert the product with the determined $category_id
        if (!$this->productModel->insertProduct($product_id, $names[$index], $category_id, $quantities[$index], $weights[$index], $prices[$index], $descriptions[$index], $imageData[$index])) {
            return ['error' => "Failed to save product with ID: $product_id"];
        }
    }

    return ['message' => 'Products successfully uploaded!'];
}


  public function getExchangeRates() {
    // Your API key from ExchangeRate-API
    $apiKey = '682d14f5fa4a1d782dc6393b';

    // ExchangeRate-API endpoint for the latest exchange rates with MYR as the base currency
    $apiUrl = "https://v6.exchangerate-api.com/v6/{$apiKey}/latest/MYR";

    // Use cURL to fetch the API response
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Decode the JSON response to get the exchange rates
    $exchangeData = json_decode($response, true);

    if (isset($exchangeData['result']) && $exchangeData['result'] == 'success') {
        // Return the exchange rates for USD, EUR, and GBP based on MYR
        return [
            'MYR' => 1, // Base currency is MYR, so no conversion needed for MYR
            'USD' => $exchangeData['conversion_rates']['USD'],
            'EUR' => $exchangeData['conversion_rates']['EUR'],
            'GBP' => $exchangeData['conversion_rates']['GBP']
        ];
    } else {
        // Handle error
        echo "Error fetching exchange rates.";
        return [];
    }
}
    // Method to handle exporting products to XML
public function exportToXML($pdo) {
    // Fetch real-time exchange rates using your API key
    $conversionRates = $this->getExchangeRates();

    // Check if we got valid exchange rates
    if (empty($conversionRates)) {
        echo "Could not fetch exchange rates.";
        return;
    }

    // Fetch products from the model
    $stmt = $pdo->query("SELECT * FROM Product");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$products) {
        echo "No products found.";
        return;
    }

    // Create a new XML document
    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="products.xsl"?><Products/>');

    // Loop through each product and add it to the XML document
    foreach ($products as $product) {
        $productNode = $xml->addChild('Product');
        $productNode->addChild('ProductID', $product['ProductID']);
        $productNode->addChild('ProductName', $product['ProductName']);
        $productNode->addChild('CategoryID', $product['CategoryID']);
        $productNode->addChild('Quantity', $product['Quantity']);
        $productNode->addChild('Weight', $product['Weight']);
        $productNode->addChild('Description', $product['Description']);

        // Add price in multiple currencies, ensuring no commas in the price
        $priceNode = $productNode->addChild('Price');
        foreach ($conversionRates as $currency => $rate) {
            // Ensure no commas by formatting with a period as the decimal separator
            $convertedPrice = $product['Price'] * $rate;
            $priceNode->addChild($currency, number_format($convertedPrice, 2, '.', ''));  // Format with no commas, two decimal places
        }

        // Add the image as base64 if it exists
        if ($product['Image']) {
            $imageData = base64_encode($product['Image']);
            $productNode->addChild('Image', $imageData);
        }
    }

    // Define the folder and file name for saving the XML
    $exportDir = '../exports/';
    if (!is_dir($exportDir)) {
        mkdir($exportDir, 0777, true);  // Create directory with write permissions
    }

    $fileName = $exportDir . 'products.xml'; // Save in 'exports' folder
    if ($xml->asXML($fileName)) {
        echo "Products exported to XML successfully! File: $fileName";
         header("Location: ../Public/productAdmin.php");  // Replace with your main page path
        exit;
    } else {
        echo "Failed to save XML file.";
    }
}


    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        $products = $this->productModel->getAllProducts();

        // Render the view and pass data
        require_once '../views/product/index.php';
    }
}

// Determine which action to take based on the 'action' parameter
// Remove the 'else' block that outputs "No valid action specified."
if (isset($_GET['action'])) {
    $controller = new ProductController($pdo); // Pass the $pdo connection here

    if ($_GET['action'] === 'exportToXML') {
        $controller->exportToXML($pdo);
    } else {
        // If no valid action is specified, return a proper JSON error
        echo json_encode(['error' => 'No valid action specified.']);
    }
}