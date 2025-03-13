<?php
//Author: Tan Yen Shi 22WMR13751
require_once '../config/Database.php';
require_once '../Models/Order.php';
require_once '../core/commands/CreateOrderCommand.php';
require_once '../Models/OrderRepositoryImpl.php';
require_once '../Models/OrderItem.php';

class updateCartController {
    public function updateCart() {

        try {
            $database = new Database();
            $pdo = $database->getConnection();
        } catch (PDOException $e) {
            error_log("An internal server error occurred.");
            header('Location: ?url=error');
            exit();
            echo "Connection failed: " . $e->getMessage();
            exit();
        }

        $customerID = $_SESSION['customerID'];
        
        $cartQuery = "SELECT * FROM Cart WHERE userID = ?";
        $cartStmt = $pdo->prepare($cartQuery);
        $cartStmt->execute([$customerID]);
        $cart = $cartStmt->fetch();

        if ($cart) {
            $orderID = $this->getNextOrderId($pdo);
            $orderDate = date('Y-m-d H:i:s');
            $status = "Pending";
            $totalAmt = $cart['TotalAmt'];

            $order = new Order($orderID, $orderDate, $status, $totalAmt, $customerID);
            $orderRepository = new OrderRepositoryImpl($pdo);

            $createCommand = new CreateOrderCommand($order, $orderRepository);
            $createCommand->execute();
            
            $_SESSION['OrderID'] = $orderID; // Store OrderID in session

            $cartItemsQuery = "SELECT * FROM CartItem WHERE CartID = ?";
            $cartItemsStmt = $pdo->prepare($cartItemsQuery);
            $cartItemsStmt->execute([$cart['CartID']]);
            $cartItems = $cartItemsStmt->fetchAll();

            foreach ($cartItems as $cartItem) {
                $orderItemID = $this->getNextOrderItemId($pdo);
                $productID = $cartItem['ProductID'];
                $quantity = $cartItem['Quantity'];
                $price = $cartItem['Price'];

                $orderItem = new OrderItem($orderItemID, $orderID, $productID, $quantity, $price);
                $orderRepository->saveOrderItem($orderItem);
            }

            // Clear the cart items first
            $clearCartItemsQuery = "DELETE FROM CartItem WHERE CartID = ?";
            $clearCartItemsStmt = $pdo->prepare($clearCartItemsQuery);
            $clearCartItemsStmt->execute([$cart['CartID']]);

            // Then clear the cart itself
            $clearCartQuery = "DELETE FROM Cart WHERE CartID = ?";
            $clearCartStmt = $pdo->prepare($clearCartQuery);
            $clearCartStmt->execute([$cart['CartID']]);

             header('Location: ?url=invoice');
        } else {
            echo "No items in cart.";
        }
    }

    private function getNextOrderId($pdo) {
        $query = "SELECT OrderID FROM `Orderr` ORDER BY OrderID DESC LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $lastOrderId = $stmt->fetchColumn();

        if ($lastOrderId) {
            $number = (int)substr($lastOrderId, 1) + 1;
            return 'O' . str_pad($number, 3, '0', STR_PAD_LEFT);
        } else {
            return 'O001';
        }
    }

    private function getNextOrderItemId($pdo) {
        $query = "SELECT OrderItemID FROM OrderItem ORDER BY OrderItemID DESC LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $lastOrderItemId = $stmt->fetchColumn();

        if ($lastOrderItemId) {
            $number = (int)substr($lastOrderItemId, 2) + 1;
            return 'OI' . str_pad($number, 3, '0', STR_PAD_LEFT);
        } else {
            return 'OI001';
        }
    }
}
?>
