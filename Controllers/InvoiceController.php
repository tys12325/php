        <?php
     //Author: Tan Yen Shi 22WMR13751   
        class InvoiceController{
            public function showInvoice(){
                date_default_timezone_set('Asia/Kuala_Lumpur'); // Set the time zone to Malaysia Time
                session_start();
                require_once '../config/Database.php';

                // Check if OrderID is set in the session
                if (isset($_SESSION['OrderID'])) {
                    $orderID = $_SESSION['OrderID'];
                } else {
                    die("No order found in the session.");
                }

                try {
                    $database = new Database();
                    $pdo = $database->getConnection();

                    // Generate InvoiceID
                    function getNextInvoiceId($pdo) {
                        $query = "SELECT InvoiceID FROM Invoice ORDER BY InvoiceID DESC LIMIT 1";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        $lastInvoiceId = $stmt->fetchColumn();

                        if ($lastInvoiceId) {
                            $number = (int)substr($lastInvoiceId, 2) + 1;
                            return 'IV' . str_pad($number, 3, '0', STR_PAD_LEFT);
                        } else {
                            return 'IV001';
                        }
                    }

                    $invoiceID = getNextInvoiceId($pdo);

                    // Insert the invoice record with DateGenerated and TimeGenerated
                    $insertInvoiceQuery = "INSERT INTO Invoice (InvoiceID, OrderID, DateGenerated, TimeGenerated) VALUES (?, ?, ?, ?)";
                    $insertInvoiceStmt = $pdo->prepare($insertInvoiceQuery);

                    // Get current date and time
                    $currentDate = date('Y-m-d'); // Current date in YYYY-MM-DD format
                    $currentTime = date('H:i:s'); // Current time in HH:MM:SS format

                    $insertInvoiceStmt->execute([$invoiceID, $orderID, $currentDate, $currentTime]);
                    $_SESSION['invoiceID'] = $invoiceID;
                    header('Location: ?url=GenerateInvoice');
                    
                } catch (PDOException $e) {
                    error_log("An internal server error occurred.");
                    header('Location: ?url=error');
                    exit();
                    die("An error occurred. Please try again later.");  // Show a generic message to the user
                    echo "Database error: " . $e->getMessage();
                }    
            }
        }

        ?>