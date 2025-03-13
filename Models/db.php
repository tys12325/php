<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

// db.php
$host = 'localhost';
$dbName = 'starlightglory';
$user = 'admin123';
$password = 'AdminUser@1234';
$dsn = "mysql:host=$host;dbname=$dbName";

try {
    $pdoObj = new PDO($dsn, $user, $password);
    $pdoObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    echo "<p>ERROR: " . $ex->getMessage() . "</p>";
    exit();
}
?>
