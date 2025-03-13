<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

require_once 'UserComponent.php';

class BasicUser implements UserComponent {
    public function login($email, $password) {
        // Logic for user login
        echo "Basic User logged in with email: $email<br>";
    }

    public function register($username, $dob, $email, $password) {
        // Logic for user registration
        echo "Basic User registered with username: $username<br>";
    }

    // Admin-specific operations are not allowed for a BasicUser
    public function createUser($username, $dob, $email, $password) {
        throw new Exception("Operation not allowed: Only admins can create users.");
    }

    public function readUser($email) {
        throw new Exception("Operation not allowed: Only admins can read user details.");
    }

    public function updateUser($email, $data) {
        throw new Exception("Operation not allowed: Only admins can update user details.");
    }

    public function deleteUser($email) {
        throw new Exception("Operation not allowed: Only admins can delete users.");
    }
}