<?php
//Name: SIA YAO QING ID:22WMR13745
require_once '../config/database_1.php';
require_once '../controllers/ProductController.php';

ini_set('display_errors', 0);  // Turn off error display
ini_set('log_errors', 1);  // Turn on error logging
ini_set('error_log', '/path/to/php-error.log');  // Set the path to the error log file

$productController = new ProductController($pdo);
$productController->index();
?>
<a href="productAdmin.php"></a>