<?php

class User {
    public $firstname;
    public $lastname;
    private $phone;
    private $email;

    public function __construct($firstname, $lastname, $phone, $email) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->phone = $phone;
        $this->email = $email;
    }

    public function changePassword() {
        return;
    }
}

class Admin extends User {
    public function blockUser() {
        return;
    }
}