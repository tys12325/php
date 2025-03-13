<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary files
require '../Models/db.php'; // Initializes $pdoObj
require '../Models/User.php';
require '../Decorator/UserDecorator.php';
require '../Decorator/LoggingUserDecorator.php';
require '../Decorator/AdminUserDecorator.php';

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['loggedin']) || !$_SESSION['isAdmin']) {
    header("Location: login.php");
    exit();
}

// Define the UserManager class
class adminController {
    private $adminUser;

    public function __construct($adminUser) {
        $this->adminUser = $adminUser; // AdminUserDecorator instance
    }

    public function handleUserAction($action, $username, $dob, $email, $password, $confirmpassword) {
        switch ($action) {
            case 'create':
                return $this->createUser($username, $dob, $email, $password, $confirmpassword);
            case 'update':
                return $this->updateUser($email, $username, $dob, $password, $confirmpassword);
            case 'delete':
                return $this->deleteUser($email);
            default:
                return "Error: Invalid action.";
        }
    }

    private function createUser($username, $dob, $email, $password, $confirmpassword) {
        if ($password !== $confirmpassword) {
            return "Error: Passwords do not match.";
        }
        $this->adminUser->createUser($username, $dob, $email, $password, $confirmpassword);
        return "User created successfully.";
    }

    private function updateUser($email, $username, $dob, $password, $confirmpassword) {
        if ($password !== $confirmpassword) {
            return "Error: Passwords do not match.";
        }
        $this->adminUser->updateUser($email, [
            'username' => $username,
            'dob' => $dob,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
        return "User updated successfully.";
    }

    private function deleteUser($email) {
        $this->adminUser->deleteUser($email);
        return "User deleted successfully.";
    }
}

// Create the user with decorators
$user = new User($pdoObj);
$loggedUser = new LoggingUserDecorator($user);
$adminUser = new AdminUserDecorator($loggedUser);

// Instantiate the UserManager
$userManager = new adminController($adminUser);

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $dob = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
    $confirmpassword = filter_input(INPUT_POST, 'confirmpassword', FILTER_DEFAULT);

    // Call the handleUserAction method in UserManager
    $message = $userManager->handleUserAction($action, $username, $dob, $email, $password, $confirmpassword);

    // Display result message
    echo $message;
}
?>
