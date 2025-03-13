<?php
require_once '../config/Database.php';
//Author: Tan Yen Shi 22WMR13751
class pastOrderController {
    public function pastOrder() {

        // Check if customer is logged in
        if (!isset($_SESSION['customerID'])) {
            $notLoggedIn = true;  // If not logged in, set flag to show a message
            require '../Views/pastOrder.php'; // Load the view to show the message
            return;
        }

        $customerID = $_SESSION['customerID']; // Get customer ID from session
        $sortOrder = isset($_GET['sort']) && $_GET['sort'] === 'asc' ? 'ASC' : 'DESC'; // Sort order based on query parameter

        try {
            $database = new Database();
            $pdo = $database->getConnection();

            // Retrieve all orders for the logged-in customer
            $ordersQuery = "
                SELECT o.OrderID, o.OrderDate, o.Status, o.TotalAmt, i.InvoiceID
                FROM Orderr o
                LEFT JOIN Invoice i ON o.OrderID = i.OrderID
                WHERE o.userID = ?
                ORDER BY o.OrderDate $sortOrder";
            $ordersStmt = $pdo->prepare($ordersQuery);
            $ordersStmt->execute([$customerID]);
            $orders = $ordersStmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("An internal server error occurred.");
            header('Location: ?url=error');
            exit();
        }

        require '../Views/pastOrder.php';
    }
}
