<?php

namespace App\Dtos;

class LoginUserDto {
    public function __construct(public $email,public $password) {
        $this->validateData();
    }

    private function validateData() {
        $this->validateEmail();
        $this->validatePassword();
    }

    private function validateEmail() {
        if (empty($this->email)) {
            throw new \Exception("Email obrigatório.");
        }
    }

    private function validatePassword() {
        if (empty($this->password)) {
            throw new \Exception("Senha obrigatória.");
        }
    }
}
