<?php

namespace Tgu\Laperdina\User;

class User {
    private $id;
    public $firstname;
    public $lastname;
    public $phone;
    public $email;

    public function __construct($id, $firstname, $lastname, $phone, $email) {
        $this->id = $id;
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