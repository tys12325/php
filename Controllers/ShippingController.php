<?php
//Author: Tan Yen Shi 22WMR13751
require_once '../config/Database.php';

class ShippingController {
    
    public function showShippingForm() {
        // Initialize session variables with default values if not already set
        if (!isset($_SESSION['fullName'])) {
            $_SESSION['fullName'] = '';
        }
        if (!isset($_SESSION['phoneNumber'])) {
            $_SESSION['phoneNumber'] = '';
        }
        if (!isset($_SESSION['Address'])) {
            $_SESSION['Address'] = '';
        }
        if (!isset($_SESSION['city'])) {
            $_SESSION['city'] = '';
        }
        if (!isset($_SESSION['state'])) {
            $_SESSION['state'] = '';
        }
        if (!isset($_SESSION['zipCode'])) {
            $_SESSION['zipCode'] = '';
        }

        // Check if customerID is in the session
        if (isset($_SESSION['customerID'])) {
            $customerID = $_SESSION['customerID'];

            try {
                // Connect to the database
                $database = new Database();
                $pdo = $database->getConnection();

                // Retrieve user address data based on customerID
                $stmt = $pdo->prepare("SELECT ua.address, ua.city, ua.state, ua.zip_code, ua.phoneNum, ru.username 
                                       FROM UserAddress ua 
                                       JOIN registeredUsers ru ON ua.userID = ru.userID 
                                       WHERE ru.userID = ?");
                $stmt->execute([$customerID]);
                $customer = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($customer) {
                    // Store fetched data into session variables
                    $_SESSION['fullName'] = $customer['username'];
                    $_SESSION['Address'] = $customer['address'];
                    $_SESSION['city'] = $customer['city'];
                    $_SESSION['state'] = $customer['state'];
                    $_SESSION['zipCode'] = $customer['zip_code'];
                    $_SESSION['phoneNumber'] = $customer['phoneNum'];
                } else {
                    $_SESSION['error'] = "No customer data found.";
                }
            } catch (PDOException $e) {
                error_log("An internal server error occurred.");
                header('Location: ?url=error');
                exit();
                die("An error occurred. Please try again later.");  // Show a generic message to the user
                $_SESSION['error'] = "Database error: " . $e->getMessage();
            }
        }

        // Load the shipping form view
        require '../Views/shipping.php';
    }

    public function handleShippingSubmission() {
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           // Retrieve the form data
           $fullName = $_POST['full_name'];
           $address = $_POST['address'];
           $city = $_POST['city'];
           $state = $_POST['state'];
           $zipCode = $_POST['zip_code'];
           $phoneNumber = $_POST['phone_number'];

           // Validate ZIP code: must be 5 digits
           if (!preg_match('/^\d{5}$/', $zipCode)) {
               $_SESSION['error'] = "Invalid ZIP code. It must be exactly 5 digits.";
               return;
           }

           // Validate phone number (Malaysian format: 01X-XXXXXXX)
           if (!preg_match('/^01[0-46-9]-\d{7,8}$/', $phoneNumber)) {
               $_SESSION['error'] = "Invalid phone number. It must be in the format 01X-XXXXXXX.";
               return;
           }

           // Continue with the existing code for processing the shipping details
           if (isset($_SESSION['customerID'])) {
               $customerID = $_SESSION['customerID'];

               try {
                   $database = new Database();
                   $pdo = $database->getConnection();

                   // Check if an address record already exists for this userID
                   $stmt = $pdo->prepare("SELECT addressID FROM UserAddress WHERE userID = ?");
                   $stmt->execute([$customerID]);
                   $existingAddress = $stmt->fetch(PDO::FETCH_ASSOC);

                   if ($existingAddress) {
                       // If a record exists, update it
                       $stmt = $pdo->prepare("UPDATE UserAddress 
                                              SET address = ?, city = ?, state = ?, zip_code = ?, phoneNum = ? 
                                              WHERE userID = ?");
                       $stmt->execute([$address, $city, $state, $zipCode, $phoneNumber, $customerID]);
                   } else {
                       // If no record exists, insert a new one
                       $stmt = $pdo->prepare("INSERT INTO UserAddress (address, city, state, zip_code, phoneNum, userID) 
                                              VALUES (?, ?, ?, ?, ?, ?)");
                       $stmt->execute([$address, $city, $state, $zipCode, $phoneNumber, $customerID]);
                   }

                   // Update session variables with submitted data
                   $_SESSION['fullName'] = $fullName;
                   $_SESSION['Address'] = $address;
                   $_SESSION['city'] = $city;
                   $_SESSION['state'] = $state;
                   $_SESSION['zipCode'] = $zipCode;
                   $_SESSION['phoneNumber'] = $phoneNumber;

                   // Redirect to the next step (e.g., invoice page)
                   header('Location: ?url=updateCart');
                   exit();
               } catch (PDOException $e) {
                   $_SESSION['error'] = "Failed to save shipping information: " . $e->getMessage();
               }
           } else {
               $_SESSION['error'] = "No customer session found.";
           }
       }
   }

}
