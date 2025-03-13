<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

session_start();
$_SESSION['loggedin'] = true;
$_SESSION['email'] = $email; // Where $email is the user's email from the form or database

require_once '../Models/User.php';
require_once '../Decorator/LoggingUserDecorator.php';
require_once '../Decorator/AdminUserDecorator.php';

class loginController {
    private $pdoObj;

    // Constructor to initialize the database connection
    public function __construct($host, $dbName, $user, $password) {
        $dsn = "mysql:host=$host;dbname=$dbName";
        try {
            $this->pdoObj = new PDO($dsn, $user, $password);
            $this->pdoObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo "<p>ERROR: " . $ex->getMessage() . "</p>";
            exit();
        }
    }

    // Public function to handle the login process
    public function loginUser() {
        // Check if the form was submitted using filter_input()
        $requestMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        if ($requestMethod === 'POST') {
            // Retrieve and sanitize user input using filter_input()
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);

            // Validate the email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../Views/failedLogIn.php"); // Redirect to login failure page
                exit();
            }

            // Check for empty input
            if (empty($email) || empty($password)) {
                header("Location: ../Views/failedLogIn.php"); // Redirect to login failure page
                exit();
            }

            // Create a base user object
            $user = new User($this->pdoObj);

            // Decorate the user with logging functionality
            $loggedUser = new LoggingUserDecorator($user);

            // Perform the login with logging
            $loginSuccessful = $loggedUser->login($email, $password);

            // Check if login was successful
            if ($loginSuccessful) {
                // If the user is an admin, decorate with AdminUserDecorator
                if ($user->isAdmin()) {
                    $adminUser = new AdminUserDecorator($loggedUser);
                    // Perform admin-specific actions here
                    header("Location: ../Views/adminDashboard.php");
                } else {
                    // Redirect to normal user dashboard
                    header("Location: ../Views/userDashboard.php");
                }
            } else {
                // Redirect to login failure page if unsuccessful
                header("Location: ../Views/failedLogIn.php");
            }
        }
    }
}

// Example usage
$loginManager = new loginController('localhost', 'starlightglory', 'admin123', 'AdminUser@1234');
$loginManager->loginUser();
?>
