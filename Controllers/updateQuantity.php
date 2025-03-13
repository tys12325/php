<?php
session_start();
require_once '../config/Database.php'; // Include your Database class
//Author: Tan Yen Shi 22WMR13751
class UpdateQuantityController {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection(); // Use the PDO connection from Database class
    }

    public function updateQuantity() {
        if (!isset($_SESSION['customerID'])) {
            // Handle the case where the session variable is not set
            echo "User not logged in.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemID = $_POST['cartItemID'];
            $quantity = intval($_POST['quantity']);
            $action = $_POST['action'];

            // Validate inputs
            if (!in_array($action, ['increment', 'decrement'])) {
                echo "Invalid action.";
                return;
            }

            // Adjust quantity based on action
            if ($action === 'increment') {
                $quantity++;
            } elseif ($action === 'decrement') {
                if ($quantity > 1) {
                    $quantity--;
                }
            }

            // Debugging information
            echo "Action: $action<br>";
            echo "Initial Quantity: " . intval($_POST['quantity']) . "<br>";
            echo "Updated Quantity: $quantity<br>";

            try {
                $this->db->beginTransaction();

                // Update the quantity in the CartItem table
                $updateQuery = "UPDATE CartItem SET Quantity = :quantity, TotalAmt = :totalAmt WHERE CartItemID = :cartItemID";
                $stmt = $this->db->prepare($updateQuery);
                $totalAmt = $quantity * $this->getProductPrice($cartItemID); // Recalculate the total amount for the item
                $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $stmt->bindParam(':totalAmt', $totalAmt, PDO::PARAM_STR);
                $stmt->bindParam(':cartItemID', $cartItemID, PDO::PARAM_STR);
                $stmt->execute();

                // Recalculate the total amount for the cart
                $cartID = $this->getCartIDByCartItemID($cartItemID);
                $stmt = $this->db->prepare("SELECT SUM(Quantity * Price) AS totalAmount FROM CartItem WHERE CartID = :cartID");
                $stmt->execute(['cartID' => $cartID]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $totalAmount = $result['totalAmount'];

                // Update the Cart table with the new total amount
                $stmt = $this->db->prepare("UPDATE Cart SET TotalAmt = :totalAmount WHERE CartID = :cartID");
                $stmt->bindParam(':totalAmount', $totalAmount, PDO::PARAM_STR);
                $stmt->bindParam(':cartID', $cartID, PDO::PARAM_STR);
                $stmt->execute();

                $this->db->commit();

                // Redirect back to the cart page
                header("Location: ../Public/index.php?url=cart");
                exit();
            } catch (PDOException $e) {
                $this->db->rollBack();
                echo "Error: " . $e->getMessage();
            }
        }
    }

    private function getProductPrice($cartItemID) {
        $stmt = $this->db->prepare("SELECT Price FROM CartItem WHERE CartItemID = :cartItemID");
        $stmt->execute(['cartItemID' => $cartItemID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Price'];
    }

    private function getCartIDByCartItemID($cartItemID) {
        $stmt = $this->db->prepare("SELECT CartID FROM CartItem WHERE CartItemID = :cartItemID");
        $stmt->execute(['cartItemID' => $cartItemID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['CartID'];
    }
}

// Create an instance of the controller and call the update method
$updateQuantityController = new UpdateQuantityController();
$updateQuantityController->updateQuantity();
?>
