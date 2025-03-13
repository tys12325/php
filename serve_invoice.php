<?php
//Author: Tan Yen Shi 22WMR13751
session_start();

// Check if the invoice XML file exists
if (file_exists('exports/invoice.xml')) {
    header('Content-Type: application/xml');
    readfile('exports/invoice.xml');
} else {
    http_response_code(404);
    echo "Invoice not found.";
}
