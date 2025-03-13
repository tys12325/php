<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../Models/User.php';
require_once '../Decorator/AdminUserDecorator.php';
require_once '../Decorator/LoggingUserDecorator.php';

class registerController {
    private $pdoObj;

    public function __construct($host, $dbName, $user, $password) {
        $dsn = "mysql:host=$host;dbname=$dbName";
        try {
            $this->pdoObj = new PDO($dsn, $user, $password);
            $this->pdoObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo "<p>ERROR: " . $ex->getMessage() . "</p>";
            exit;
        }
    }

    public function registerUser() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve user input from the form
            $username = $_POST['username'];
            $dob = $_POST['dob'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmpassword = $_POST['confirmpassword'];

            if ($this->validateInput($email, $password, $confirmpassword)) {

                $user = new User($this->pdoObj);

                $loggedUser = new LoggingUserDecorator($user);

                $loggedUser->register($username, $dob, $email, $password, $confirmpassword);

            }
        }
    }

    private function validateInput($email, $password, $confirmpassword) {
        // Check if passwords match
        if ($password !== $confirmpassword) {
            echo "<p>ERROR: Passwords do not match!</p>";
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p>ERROR: Invalid email format!</p>";
            return false;
        }

        return true;
    }
}

// Usage example
$registrationManager = new registerController('localhost', 'starlightglory', 'admin123', 'AdminUser@1234');
$registrationManager->registerUser();
?>
