<?php
//Author: Tan Yen Shi 22WMR13751
class updatePaymentController{
    public function updatePayment(){
            date_default_timezone_set('Asia/Kuala_Lumpur'); // Set the time zone to Malaysia Time
            require_once '../Models/Order.php';
            require_once '../core/commands/UpdateOrderCommand.php';
            require_once '../Models/OrderRepositoryImpl.php';
            require_once '../Models/OrderItem.php';
            require_once '../config/Database.php';


            // Check if InvoiceID is set in the session
            if (isset($_SESSION['invoiceID'])) {
                $invoiceID = $_SESSION['invoiceID'];
            } else {
                die("No invoice found in the session.");
            }

            try {
                $database = new Database();
                $pdo = $database->getConnection();

                // Retrieve OrderID from the Invoice table
                $orderQuery = "SELECT OrderID FROM Invoice WHERE InvoiceID = ?";
                $orderStmt = $pdo->prepare($orderQuery);
                $orderStmt->execute([$invoiceID]);
                $orderID = $orderStmt->fetchColumn();

                if (!$orderID) {
                    die("No order associated with the given invoice.");
                }

                // Retrieve TotalAmt from the Orderr table
                $amountQuery = "SELECT TotalAmt FROM `Orderr` WHERE OrderID = ?";
                $amountStmt = $pdo->prepare($amountQuery);
                $amountStmt->execute([$orderID]);
                $amount = $amountStmt->fetchColumn();

                if (!$amount) {
                    die("No amount found for the given order.");
                }

                // Generate PaymentID
                function getNextPaymentId($pdo) {
                    $query = "SELECT PaymentID FROM Payment ORDER BY PaymentID DESC LIMIT 1";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $lastPaymentId = $stmt->fetchColumn();

                    if ($lastPaymentId) {
                        $number = (int)substr($lastPaymentId, 1) + 1;
                        return 'P' . str_pad($number, 3, '0', STR_PAD_LEFT);
                    } else {
                        return 'P001';
                    }
                }

                $paymentID = getNextPaymentId($pdo);

                // Insert the payment record with PaymentDate and PaymentTime
                $insertPaymentQuery = "INSERT INTO Payment (PaymentID, PaymentDate, PaymentTime, Amount, InvoiceID) VALUES (?, ?, ?, ?, ?)";
                $insertPaymentStmt = $pdo->prepare($insertPaymentQuery);

                // Get current date and time
                $currentDate = date('Y-m-d'); // Current date in YYYY-MM-DD format
                $currentTime = date('H:i:s'); // Current time in HH:MM:SS format

                $insertPaymentStmt->execute([$paymentID, $currentDate, $currentTime, $amount, $invoiceID]);
                $_SESSION['paymentID'] = $paymentID;

                $_SESSION['orderID'] = $orderID;

                try {
                    // Query to retrieve order details using the orderID
                    $orderDetailsQuery = "SELECT OrderDate, Status, TotalAmt, userID FROM `Orderr` WHERE OrderID = ?";
                    $orderDetailsStmt = $pdo->prepare($orderDetailsQuery);
                    $orderDetailsStmt->execute([$orderID]);

                    // Fetch the order details
                    $orderDetails = $orderDetailsStmt->fetch(PDO::FETCH_ASSOC);

                    if ($orderDetails) {
                        // Extract individual values
                        $orderDate = $orderDetails['OrderDate'];
                        $status = $orderDetails['Status'];
                        $totalAmt = $orderDetails['TotalAmt'];
                        $userID = $orderDetails['userID'];

                        // Create an Order object with the retrieved data
                        $order = new Order($orderID, $orderDate, $status, $totalAmt, $userID);

                        // You can now use this $order object as needed, for example, to update the order status
                        $orderRepository = new OrderRepositoryImpl($pdo);
                        $updateCommand = new UpdateOrderCommand($order, $orderRepository);
                        $updateCommand->execute();
                    } else {
                        die("Order not found in the database.");
                    }

                } catch (PDOException $e) {
                    error_log("An internal server error occurred.");
                    header('Location: ?url=error');
                    exit();
                    die("An error occurred. Please try again later.");  // Show a generic message to the user
                    echo "Database error: " . $e->getMessage();
                }


            } catch (PDOException $e) {
                error_log("An internal server error occurred.");
                header('Location: ?url=error');
                exit();
                die("An error occurred. Please try again later.");  // Show a generic message to the user
                echo "Database error: " . $e->getMessage();
            } 
            require'../Views/continuePayment.php';
            //header("Location: ?url=sendMail");

        
    }
}
?>