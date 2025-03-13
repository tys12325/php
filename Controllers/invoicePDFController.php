<?php
use Dompdf\Options;
use Dompdf\Dompdf;
require_once '../config/Database.php';
require '../vendor/autoload.php';
//Author: Tan Yen Shi 22WMR13751
class invoicePDFController{
    public function genPDF(){
        
        // Ensure OrderID, CustomerID, and invoiceID are set in the session
        if (!isset($_SESSION['OrderID']) || !isset($_SESSION['customerID']) || !isset($_SESSION['invoiceID'])) {
            die("No order or customer found in the session.");
        }

        $orderID = $_SESSION['OrderID'];
        $customerID = $_SESSION['customerID'];
        $invoiceID = $_SESSION['invoiceID'];

        try {
            $database = new Database();
            $pdo = $database->getConnection();

            // Retrieve order details
            $orderQuery = "SELECT * FROM `Orderr` WHERE OrderID = ?";
            $orderStmt = $pdo->prepare($orderQuery);
            $orderStmt->execute([$orderID]);
            $order = $orderStmt->fetch(PDO::FETCH_ASSOC);

            if (!$order) {
                die("Order not found.");
            }

            // Retrieve customer details
            $customerQuery = "SELECT * FROM registeredUsers WHERE userID = ?";
            $customerStmt = $pdo->prepare($customerQuery);
            $customerStmt->execute([$customerID]);
            $customer = $customerStmt->fetch(PDO::FETCH_ASSOC);

            if (!$customer) {
                die("Customer not found.");
            }

            // Retrieve order items with product details
            $orderItemsQuery = "
                SELECT oi.Quantity, oi.Price, p.ProductName, p.Weight
                FROM OrderItem oi
                JOIN Product p ON oi.ProductID = p.ProductID
                WHERE oi.OrderID = ?";
            $orderItemsStmt = $pdo->prepare($orderItemsQuery);
            $orderItemsStmt->execute([$orderID]);
            $orderItems = $orderItemsStmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("An internal server error occurred.");
            header('Location: ?url=error');
            exit();
            die("An error occurred. Please try again later.");  // Show a generic message to the user
            die("Database error: " . $e->getMessage());
        }

        // Generate HTML content for Dompdf
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Invoice #' . htmlspecialchars($order['OrderID']) . '</title>
            <style> 
                body { font-family: Arial, sans-serif; }
                .container { width: 80%; margin: auto; }
                .header { text-align: center; margin-bottom: 20px; }
                .info { margin-bottom: 20px; }
                .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
                .info-item { flex: 1; }
                .info-item-right { text-align: right; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                table, th, td { border: 1px solid black; }
                th, td { padding: 10px; text-align: left; }
                th { background-color: #333; color: white; }
                .total { text-align: right; font-weight: bold; }
                .footer { text-align: center; margin-top: 20px; }
                .highlighted { font-weight: bold; }
                .details ul { list-style: none; padding: 0; }
                .details li { margin: 5px 0; }
                .large-circled-number { font-size: 24px; background: #ddd; border-radius: 50%; padding: 10px; display: inline-block; }
                .long-line { border-top: 1px solid #000; margin: 10px 0; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Invoice #' . htmlspecialchars($invoiceID) . '</h1>
                </div>

                <div class="info">
                    <div class="info-row">
                        <div class="info-item">
                            <p><strong style="font-size: 18px">Invoice To:<br></strong> ' . htmlspecialchars($customer['username'] . ' ' . $customer['LastName']) . '</p>
                            <p><strong>Address:</strong> ' . htmlspecialchars($_SESSION['address']) . '</p>
                        </div>
                        <div class="info-item info-item-right">
                            <p><strong>Order ID:</strong> ' . htmlspecialchars($order['OrderID']) . '</p>
                            <p><strong>Generated Date:</strong> ' . htmlspecialchars($order['OrderDate']) . '</p>
                            <p><strong>Status:</strong> ' . htmlspecialchars($order['Status']) . '</p>
                        </div>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Weight</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($orderItems as $item) {
            $html .= '<tr>
                <td>' . htmlspecialchars($item['ProductName']) . '</td>
                <td>' . htmlspecialchars($item['Weight']) . ' kg</td>
                <td>' . htmlspecialchars($item['Quantity']) . '</td>
                <td>$' . number_format($item['Price'], 2) . '</td>
                <td>$' . number_format($item['Price'] * $item['Quantity'], 2) . '</td>
            </tr>';
        }

        $html .= '
                    </tbody>
                </table>

                <div class="total">
                    <p>Total Amount: $' . number_format($order['TotalAmt'], 2) . '</p>
                </div>
            </div>
        </body>
        </html>';

        // Initialize Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        // Load HTML content
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        ob_end_clean(); // Clear any output buffering

        $dompdf->render();

        $pdfPath = 'invoice_' . $invoiceID . '.pdf';
        file_put_contents($pdfPath, $dompdf->output());

        // Stream PDF to browser
        $filename = 'invoice_' . $invoiceID . '.pdf';
        $dompdf->stream($filename, array('Attachment' => 1)); // 1 for download




    }
}
