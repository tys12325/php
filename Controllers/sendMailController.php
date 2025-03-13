<?php
require_once '../config/Database.php'; // Adjust the path if necessary
require '../vendor/autoload.php'; // Ensure this line includes the autoload file
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Author: Tan Yen Shi 22WMR13751
class sendMailController{
    public function sendMail(){
        
        // Ensure that necessary session variables are set
        if (!isset($_SESSION['OrderID']) || !isset($_SESSION['customerID']) || !isset($_SESSION['invoiceID'])) {
            die("Order, customer, or invoice details not found in the session.");
        }

        $invoicePath = 'invoice_' . $_SESSION['invoiceID'] . '.pdf';
        if (!file_exists($invoicePath)) {
            die("Invoice PDF file not found.");
        }

        $invoiceID = $_SESSION['invoiceID'];
        $customerID = $_SESSION['customerID'];

        try {
            // Initialize database connection
            $database = new Database();
            $pdo = $database->getConnection();

            // Retrieve customer email from the database
            $emailQuery = "SELECT email FROM registeredUsers WHERE userID = ?";
            $emailStmt = $pdo->prepare($emailQuery);
            $emailStmt->execute([$customerID]);
            $customerEmail = $emailStmt->fetchColumn();

            if (!$customerEmail) {
                die("Customer email not found.");
            }
            
            // Send an email with PDF attachment
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'ystan-wp21@student.tarc.edu.my'; // Your Gmail address
                $mail->Password = 'cfoy oxod ogbs xkyx'; // Your Gmail App password or account password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
                $mail->Port = 587; // TCP port to connect to

                // Recipients
                $mail->setFrom('StarlightGlory@gmail.com', 'Starlight Glory');
                $mail->addAddress($customerEmail);

                // Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = 'Order Placed Successfully!  Your Invoice #' . htmlspecialchars($invoiceID);
                $mail->Body    = 'Dear Customer,<br><br>Attached is your invoice. Thank you for your purchase.<br><br>Best Regards,<br>Starlight Glory';

                // Attach PDF file
                $mail->addAttachment($invoicePath);

                $mail->send();
                require'../Views/completePayment.php';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        } catch (PDOException $e) {
            die("An error occurred. Please try again later.");  // Show a generic message to the user
            echo "Database error: " . $e->getMessage();
        }
    }
}