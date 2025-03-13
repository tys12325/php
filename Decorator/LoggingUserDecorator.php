<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

require_once 'UserDecorator.php';

class LoggingUserDecorator extends UserDecorator {
    // File to store logs
    private $logFile;

    public function __construct($userComponent) {
        parent::__construct($userComponent);
    }

    public function login($email, $password) {
        // Add logging functionality
        $this->log("INFO: User login attempt for email: $email");
        parent::login($email, $password);
    }

    public function register($username, $dob, $email, $password, $confirmpassword) {
        // Add logging functionality
        $this->log("INFO: User registration attempt for username: $username");
        parent::register($username, $dob, $email, $password, $confirmpassword);
    }

     private function log($message) {
        // Create a timestamp for the log entry
        $timestamp = date("Y-m-d H:i:s");
        // Create the full log message
        $logMessage = "[$timestamp] $message" . PHP_EOL;
        // Save the log message to the user_log.txt file
        file_put_contents('/Applications/XAMPP/xamppfiles/htdocs/test/user_log.txt', $logMessage, FILE_APPEND);
    }
}
?>