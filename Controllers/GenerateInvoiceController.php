<?php
//Author: Tan Yen Shi 22WMR13751
class GenerateInvoiceController {
    public function GenInvoice() {
        require_once '../config/Database.php';

        // Ensure OrderID and CustomerID are set in the session
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

            // Retrieve address data
            $addressQuery = "SELECT * FROM UserAddress WHERE userID = ?";
            $addressStmt = $pdo->prepare($addressQuery);
            $addressStmt->execute([$customerID]);
            $addressData = $addressStmt->fetch(PDO::FETCH_ASSOC);

            if ($addressData) {
                $_SESSION['address'] = $addressData['address'] . ', ' . $addressData['city'] . ', ' . $addressData['state'] . ' ' . $addressData['zip_code'];
                $_SESSION['phoneNumber'] = $addressData['phoneNum'];
            } else {
                $_SESSION['error'] = "No address data found.";
            }

            // Retrieve order items
            $orderItemsQuery = "
                SELECT oi.Quantity, oi.Price, p.ProductName, p.Weight
                FROM OrderItem oi
                JOIN Product p ON oi.ProductID = p.ProductID
                WHERE oi.OrderID = ?";
            $orderItemsStmt = $pdo->prepare($orderItemsQuery);
            $orderItemsStmt->execute([$orderID]);
            $orderItems = $orderItemsStmt->fetchAll(PDO::FETCH_ASSOC);

            // Generate XML
            $this->generateXML($order, $customer, $orderItems, $invoiceID);

            require '../Views/generateInvoice.php';
        } catch (PDOException $e) {
            error_log("An internal server error occurred.");
            header('Location: ?url=error');
            exit();
        }
    }

    private function generateXML($order, $customer, $orderItems, $invoiceID) {
        $xml = new DOMDocument('1.0', 'UTF-8');
        $root = $xml->createElement('Invoice');
        $xml->appendChild($root);

        $orderElem = $xml->createElement('Order');
        $orderElem->appendChild($xml->createElement('OrderID', $order['OrderID']));
        $orderElem->appendChild($xml->createElement('OrderDate', $order['OrderDate']));
        $orderElem->appendChild($xml->createElement('Status', $order['Status']));
        $orderElem->appendChild($xml->createElement('TotalAmt', $order['TotalAmt']));
        $root->appendChild($orderElem);

        $customerElem = $xml->createElement('Customer');
        $customerElem->appendChild($xml->createElement('CustomerName', $customer['username']));
        $customerElem->appendChild($xml->createElement('Address', $_SESSION['address']));
        $root->appendChild($customerElem);

        // Add the invoice ID
        $root->appendChild($xml->createElement('InvoiceID', $invoiceID));

        $orderItemsElem = $xml->createElement('OrderItems');
        foreach ($orderItems as $item) {
            $itemElem = $xml->createElement('Item');
            $itemElem->appendChild($xml->createElement('ProductName', $item['ProductName']));
            $itemElem->appendChild($xml->createElement('Weight', $item['Weight']));
            $itemElem->appendChild($xml->createElement('Quantity', $item['Quantity']));
            $itemElem->appendChild($xml->createElement('Price', $item['Price']));
            $itemElem->appendChild($xml->createElement('Total', $item['Price'] * $item['Quantity']));
            $orderItemsElem->appendChild($itemElem);
        }
        $root->appendChild($orderItemsElem);

        // Save XML to file
        $xml->save('../exports/invoice.xml');
    }

    public function getInvoiceJavaScript() {
        return '
        <script>
            function loadInvoiceData() {
                const xmlFile = "../exports/invoice.xml";
                const xsltFile = "../xslt/invoice.xsl";

                const xhttp = new XMLHttpRequest();
                xhttp.open("GET", xmlFile, true);
                xhttp.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        const xml = this.responseXML;

                        const xslHttp = new XMLHttpRequest();
                        xslHttp.open("GET", xsltFile, true);
                        xslHttp.onreadystatechange = function () {
                            if (this.readyState === 4 && this.status === 200) {
                                const xsl = this.responseXML;
                                const xsltProcessor = new XSLTProcessor();
                                xsltProcessor.importStylesheet(xsl);
                                const resultDocument = xsltProcessor.transformToFragment(xml, document);

                                const tbody = document.getElementById("items-table").getElementsByTagName("tbody")[0];
                                tbody.innerHTML = ""; 
                                tbody.appendChild(resultDocument);

                                document.getElementById("invoice-id").innerText = xml.getElementsByTagName("Invoice")[0].getElementsByTagName("InvoiceID")[0].textContent;
                                document.getElementById("customer-name").innerText = xml.getElementsByTagName("Customer")[0].getElementsByTagName("CustomerName")[0].textContent;
                                document.getElementById("customer-address").innerText = xml.getElementsByTagName("Customer")[0].getElementsByTagName("Address")[0].textContent;
                                document.getElementById("order-id").innerText = xml.getElementsByTagName("Order")[0].getElementsByTagName("OrderID")[0].textContent;
                                document.getElementById("order-date").innerText = xml.getElementsByTagName("Order")[0].getElementsByTagName("OrderDate")[0].textContent;
                                document.getElementById("order-status").innerText = xml.getElementsByTagName("Order")[0].getElementsByTagName("Status")[0].textContent;
                                document.getElementById("total-amount").innerText = xml.getElementsByTagName("Order")[0].getElementsByTagName("TotalAmt")[0].textContent;

                                if (xml.getElementsByTagName("Order")[0].getElementsByTagName("Status")[0].textContent === "Pending") {
                                    document.getElementById("checkout-link").style.display = "block";
                                }
                            }
                        };
                        xslHttp.send();
                    }
                };
                xhttp.send();
            }

            window.onload = loadInvoiceData;
        </script>
        ';
    }

}

?>

