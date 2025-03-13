<?php
//Author: Tan Yen Shi 22WMR13751

class setOrderIDController{
    function setOrderID(){
        // Check if OrderID and InvoiceID are passed via the query string
        if (isset($_GET['orderID']) && isset($_GET['invoiceID'])) {
            $_SESSION['OrderID'] = $_GET['orderID'];
            $_SESSION['invoiceID'] = $_GET['invoiceID'];
            header('Location: ?url=GenerateInvoice');
            exit();
        } else {
            die("Order ID or Invoice ID is missing.");
        }

    }
}
