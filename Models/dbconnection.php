<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

// Establish a connection to the MySQL database using mysqli
$con = mysqli_connect("localhost", "admin123", "AdminUser@1234", "starlightglory");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully";

// You can now perform database operations here

// Close the connection when done
mysqli_close($con);
?>
