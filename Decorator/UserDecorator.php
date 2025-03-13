<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

require_once 'UserComponent.php';

abstract class UserDecorator implements UserComponent {
    protected $userComponent;

    public function __construct(UserComponent $userComponent) {
        $this->userComponent = $userComponent;
    }

    public function createUser($username, $dob, $email, $password, $confirmpassword) {
        $this->userComponent->createUser($username, $dob, $email, $password, $confirmpassword);
    }

    public function readUser($email) {
        return $this->userComponent->readUser($email);
    }

    public function updateUser($email, $data) {
        $this->userComponent->updateUser($email, $data);
    }

    public function deleteUser($email) {
        $this->userComponent->deleteUser($email);
    }

    public function login($email, $password) {
        $this->userComponent->login($email, $password);
    }

    public function register($username, $dob, $email, $password, $confirmpassword) {
        $this->userComponent->register($username, $dob, $email, $password, $confirmpassword);
    }
}
?>