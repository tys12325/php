<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

// Display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
$host = 'localhost';
$dbName = 'starlightglory'; // Change this to your actual database name
$dbUser = 'admin123';
$dbPass = 'AdminUser@1234';
$dsn = "mysql:host=$host;dbname=$dbName";

// Connect to the database using mysqli
$con = new mysqli($host, $dbUser, $dbPass, $dbName);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
echo "Connected successfully<br>";

// Execute query to get registered users
$result = $con->query("SELECT * FROM registeredUsers");

if (!$result) {
    die("Error: Could not execute query. " . $con->error);
} else {
    echo "Query executed successfully<br>";
}

// Create XML document
$xml = new DomDocument('1.0', 'UTF-8');
$xml->formatOutput = true;

$users = $xml->createElement("users");
$xml->appendChild($users);

while ($row = $result->fetch_assoc()) {
    $user = $xml->createElement("user");
    $users->appendChild($user);
    
    $userID = $xml->createElement("userID", $row['userID']);
    $user->appendChild($userID);

    $username = $xml->createElement("username", $row['username']);
    $user->appendChild($username);

    $email = $xml->createElement("email", $row['email']);
    $user->appendChild($email);

    $dob = $xml->createElement("dob", $row['dob']);
    $user->appendChild($dob);
    
    $password = $xml->createElement("password", $row['password']);
    $user->appendChild($password);
}

// Save XML to file
$filePath = "users.xml";
if ($xml->save($filePath)) {
    echo "XML file created successfully: $filePath";
} else {
    echo "Error: Unable to save the XML file.";
}

// Display XML content
echo "<xmp>" . $xml->saveXML() . "</xmp>";

// Close the database connection
$con->close();
?>