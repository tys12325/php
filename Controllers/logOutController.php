<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

class logOutController {
    // Method to logout the user
    public function logoutUser() {
        session_start();
        session_unset();  // Clear all session variables
        session_destroy(); // Destroy the session
        header("Location: ../Views/userLogin.php"); // Redirect to login page
        exit();
    }
}

// Usage example
$sessionManager = new logOutController();
$sessionManager->logoutUser();

