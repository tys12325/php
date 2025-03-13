<?php
require_once '../config/Database.php'; // Include your Database class
//Author: Tan Yen Shi 22WMR13751
class CartController {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection(); // Use the PDO connection from Database class
    }

    public function displayCart() {
        if (!isset($_SESSION['customerID'])) {
            // Handle the case where the session variable is not set
            echo "User not logged in.";
            return;
        }

        $userID = $_SESSION['customerID']; // Ensure this session variable is set

        // Retrieve the user's cart
        $cartQuery = "SELECT CartID FROM Cart WHERE userID = :userID";
        $stmt = $this->db->prepare($cartQuery);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) {
            $cartID = $cart['CartID'];

            // Retrieve and aggregate the cart items along with product details
            $cartItemsQuery = "SELECT ci.CartItemID,ci.Price,p.ProductID, p.ProductName, p.Image, p.Weight, SUM(ci.Quantity) AS Quantity
                               FROM CartItem ci
                               JOIN Product p ON ci.ProductID = p.ProductID
                               WHERE ci.CartID = :cartID
                               GROUP BY p.ProductID, p.ProductName, p.Price, p.Image, p.Weight";
            $stmt = $this->db->prepare($cartItemsQuery);
            $stmt->bindParam(':cartID', $cartID, PDO::PARAM_STR);
            $stmt->execute();
            $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Prepare cart items with base64 image data
            $items = [];
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $image = $item['Image'];
                $base64Image = base64_encode($image);
                $item['Image'] = 'data:image/jpeg;base64,' . $base64Image; // Adjust MIME type as needed
                $items[] = $item;

                // Calculate total amount
                $totalAmount += $item['Quantity'] * $item['Price'];
            }

            // Pass data to the view
            $data = [
                'items' => $items,
                'totalAmount' => $totalAmount
            ];

            require '../Views/Cart.php';
        } else {
            // No cart found, still pass to view to handle the empty cart case
            $data = [
                'items' => [],
                'totalAmount' => 0
            ];
            require '../Views/Cart.php';
        }
    }
}
?>
