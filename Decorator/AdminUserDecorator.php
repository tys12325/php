<?php
//Name: FOONG SIANG HOONG ID:22WMR13703


require_once 'UserDecorator.php';

class AdminUserDecorator extends UserDecorator {

    private $logFile;

    public function __construct($userComponent) {
        parent::__construct($userComponent);
    }
  
    public function login($email, $password) {
        $this->log("Admin Login: Performing additional admin checks for user with email: $email");
        parent::login($email, $password);
    }

    public function createUser($username, $dob, $email, $password, $confirmpassword) {
        parent::createUser($username, $dob, $email, $password, $confirmpassword);
        $this->log("Admin created a new user with email: $email");
    }

    public function readUser($email) {
        $user = parent::readUser($email);
        if ($user) {
            $this->log("Admin read user details for email: $email");
            echo "Admin read user details: " . print_r($user, true) . "<br>";
        } else {
            $this->log("Admin attempted to read user details for non-existent email: $email");
            echo "User not found.<br>";
        }
    }

    public function updateUser($email, $data) {
        parent::updateUser($email, $data);
        $this->log("Admin updated user details for email: $email");
    }

    public function deleteUser($email) {
        parent::deleteUser($email);
        $this->log("Admin deleted a user with email: $email");
    }

     private function log($message) {
        // Create a timestamp for the log entry
        $timestamp = date("Y-m-d H:i:s");
        // Create the full log message
        $logMessage = "[$timestamp] $message" . PHP_EOL;
        // Save the log message to the user_log.txt file
        file_put_contents('/Applications/XAMPP/xamppfiles/htdocs/test/admin_log.txt', $logMessage, FILE_APPEND);
    }
}


