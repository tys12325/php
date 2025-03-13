<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

// Load the XML file
$xml = simplexml_load_file('users.xml');

// Specify the email to search for
$email = 'foongsh-wp21@student.tarc.edu.my';

// Search for the user by email using XPath
$user = $xml->xpath("//user[email='$email']");

if (!empty($user)) {
    // If user is found, display user details
    echo "User found:<br>";
    echo "UserID: " . $user[0]->userID . "<br>";
    echo "Username: " . $user[0]->username . "<br>";
    echo "Email: " . $user[0]->email . "<br>";
    echo "Password: " . $user[0]->password . "<br>";  // Usually, passwords are not displayed like this for security reasons
} else {
    // If user is not found, display a message
    echo "User not found.";
}
?>
