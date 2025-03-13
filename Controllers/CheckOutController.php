<?php
require '../vendor/autoload.php';
require_once '../config/Database.php';
//Author: Tan Yen Shi 22WMR13751
class CheckOutController {
    public function CheckOut() {
        $stripe_secret_key = "sk_test_51PvhrCP8NfK0OW2BCVeEMIsTgRVXWFh57cpCQzLaWPG0YIHTmqaiptzHnY5oECsflKBp5IBURSXOoxFQGrQObMLm00lGt5Bmz0";

        // Ensure the customer is logged in and has a session
        if (!isset($_SESSION['customerID'])) {
            die("CustomerID is missing. Please log in.");
        }
        $customerID = $_SESSION['customerID'];

        // Initialize database connection
        try {
            $database = new Database();
            $pdo = $database->getConnection();

            $orderID = $_SESSION['OrderID'];

            // Fetch order item details from the OrderItem table
            $query = "
                SELECT p.ProductName, oi.Quantity, oi.Price AS UnitPrice
                FROM OrderItem oi
                INNER JOIN Product p ON oi.ProductID = p.ProductID
                WHERE oi.OrderID = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$orderID]);
            $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Check if any order items were found
            if (empty($orderItems)) {
                die("No items found for the given order.");
            }

            // Prepare line items array for Stripe Checkout
            $line_items = [];
            $itemTotals = [];

            // Aggregate quantities and prices
            foreach ($orderItems as $item) {
                $key = $item['ProductName'] . "|" . $item['UnitPrice'];
                if (!isset($itemTotals[$key])) {
                    $itemTotals[$key] = [
                        "quantity" => 0,
                        "price" => $item['UnitPrice'],
                        "product_name" => $item['ProductName']
                    ];
                }
                $itemTotals[$key]['quantity'] += $item['Quantity'];
            }

            // Manually construct the post data
            $post_fields = "payment_method_types[]=card";
            $post_fields .= "&mode=payment";
            $post_fields .= "&success_url=" . urlencode("http://localhost/JewellerySaleManagementSystem/Public/index.php?url=updatePayment");
            $post_fields .= "&cancel_url=" . urlencode("http://localhost/JewellerySaleManagementSystem/Views/homePage.php");

            // Add line_items to the post fields manually
            $i = 0;
            foreach ($itemTotals as $total) {
                $post_fields .= "&line_items[$i][quantity]=" . $total['quantity'];
                $post_fields .= "&line_items[$i][price_data][currency]=MYR";
                $post_fields .= "&line_items[$i][price_data][unit_amount]=" . ($total['price'] * 100); // Convert price to cents
                $post_fields .= "&line_items[$i][price_data][product_data][name]=" . urlencode($total['product_name']);
                $i++;
            }

            // Initialize cURL
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.stripe.com/v1/checkout/sessions",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer $stripe_secret_key",
                    "Content-Type: application/x-www-form-urlencoded"
                ],
                CURLOPT_POSTFIELDS => $post_fields  // Send the manually constructed form data
            ]);

            $response = curl_exec($curl);
            curl_close($curl);

            // Decode the response from Stripe
            $result = json_decode($response, true);

            if (isset($result['error'])) {
                throw new Exception($result['error']['message']);
            }

            // Redirect the customer to the Stripe Checkout page
            if (isset($result['url'])) {
                http_response_code(303);
                header("Location: " . $result['url']);
            } else {
                error_log("An internal server error occurred.");
                header('Location: ?url=error');
                exit(); 
                throw new Exception("An error occurred while creating the checkout session.");
            }

        } catch (PDOException $e) {
            // Handle database errors
            error_log("An internal server error occurred.");
            header('Location: ?url=error');
            exit(); 
            die("An error occurred. Please try again later.");  // Show a generic message to the user
        } catch (Exception $e) {
            error_log("An internal server error occurred.");
            header('Location: ?url=error');
            exit(); 
            die("An error occurred. Please try again later.");  // Show a generic message to the user
        }
    }
}
