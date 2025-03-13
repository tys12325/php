<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

interface UserComponent {
    // Basic user operations
    public function login($email, $password);
    public function register($username, $dob, $email, $password, $confirmpassword);
    
    // Admin-specific operations
    public function createUser($username, $dob, $email, $password, $confirmpassword);
    public function readUser($email);
    public function updateUser($email, $data);
    public function deleteUser($email);
}