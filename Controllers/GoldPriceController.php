
<?php
//Name: SIA YAO QING ID:22WMR13745
require_once '../config/database_1.php';
require_once '../Models/GoldPriceSubject.php';
require_once '../Models/ProductObserver.php';

class GoldPriceController {
    private $goldPriceSubject;

    public function __construct() {
        $db = new Database();
        $pdo = $db->getConnection();

        // Initialize GoldPriceSubject (the Observable)
        $this->goldPriceSubject = new GoldPriceSubject();

        // Fetch all products that depend on the gold price
        $stmt = $pdo->query("SELECT ProductID, weight FROM product");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Attach each product as an observer to the gold price subject
        foreach ($products as $product) {
            $observer = new ProductObserver($pdo, $product['ProductID'], $product['weight']);
            $this->goldPriceSubject->attach($observer);
        }
    }

    // Function to update the gold price and notify observers
    public function updateGoldPrice($newGoldPrice) {
        // Set the new gold price in the GoldPriceSubject
        $this->goldPriceSubject->setGoldPrice($newGoldPrice);

        // Redirect to the main page after success
        header("Location: ../Public/productAdmin.php");  // Replace with your main page path
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['gold_price']) && is_numeric($_POST['gold_price'])) {
        $goldPrice = (float) $_POST['gold_price'];

        // Create the controller and update the gold price
        $controller = new GoldPriceController();
        $controller->updateGoldPrice($goldPrice);
    } else {
        // Redirect back to the form with an error message if invalid input
        header("Location: ../Views/GoldPrice/goldpriceview.html?error=1");
        exit;
    }
}
