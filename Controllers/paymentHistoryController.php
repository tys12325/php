<?php
require_once '../config/Database.php';
//Author: Tan Yen Shi 22WMR13751
class paymentHistoryController {
    public function paymentHistory() {
        // Check if customerID is stored in the session
        if (!isset($_SESSION['customerID'])) {
            // If not logged in, display a message and return
            $notLoggedIn = true;  // Set a flag to handle output in the view
            require '../Views/paymentHistory.php'; // Load the view to show the message
            return;
        }

        $customerID = $_SESSION['customerID']; // Fetch customerID from session
        $sortOrder = isset($_GET['sort']) && $_GET['sort'] === 'asc' ? 'ASC' : 'DESC'; // Determine sort order

        $payments = []; // Initialize $payments as an empty array to avoid warnings

        try {
            $database = new Database();
            $pdo = $database->getConnection();

            // Retrieve all payments for the logged-in customer
            $paymentsQuery = "
                SELECT p.PaymentID, p.PaymentDate, p.PaymentTime, p.Amount, i.InvoiceID
                FROM Payment p
                JOIN Invoice i ON p.InvoiceID = i.InvoiceID
                JOIN `Orderr` o ON i.OrderID = o.OrderID
                WHERE o.userID = ?
                ORDER BY p.PaymentDate $sortOrder, p.PaymentTime DESC";
            $paymentsStmt = $pdo->prepare($paymentsQuery);
            $paymentsStmt->execute([$customerID]);
            $payments = $paymentsStmt->fetchAll(PDO::FETCH_ASSOC);

            // Check if no payments were found
            if (empty($payments)) {
                $noPayments = true;  // Set a flag to handle output in the view
            }

        } catch (PDOException $e) {
            error_log("An internal server error occurred.");
            header('Location: ?url=error');
            exit();
        }

        require '../Views/paymentHistory.php'; // Load the payment history view
    }
}
