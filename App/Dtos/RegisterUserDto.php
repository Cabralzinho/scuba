<?php

namespace App\Dtos;

use Exception;

class RegisterUserDto {
    public function __construct(
        public $name,
        public $email,
        public $password,
        public $confirmPassword
    ) {
        $this->validateData();
    }

    private function validateData() {
        $this->validateName();
        $this->validateEmail();
        $this->validatePassword();
        $this->validateConfirmPassword();
    }

    private function validateName() {
        if (empty($this->name)) {
            throw new Exception('O nome não pode estar vazio');
        }
    }

    private function validateEmail() {
        if (empty($this->email)) {
            throw new Exception('O e-mail não pode estar vazio');
        }
    }

    private function validatePassword() {
        if (empty($this->password)) {
            throw new Exception('A senha não pode estar vazia');
        }
    }

    private function validateConfirmPassword() {
        if (empty($this->confirmPassword)) {
            throw new Exception('O campo de confirmação de senha não pode estar vazio');
        }
    }
}