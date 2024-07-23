<?php

namespace App\Services\Auth;

use App\Dtos\RegisterUserDto;
use App\Models\UserModel;
use Exception;

class RegisterService {

    public function __construct(
        private RegisterUserDto $dto
    ) {
        $this->validateData();
    }

    public function register() {
        try {
            $passwordHash = password_hash($this->dto->password, PASSWORD_DEFAULT);

            UserModel::registerUser($this->dto->name, $this->dto->email, $passwordHash);
        } catch (Exception $error) {
            throw new Exception($error->getMessage());
        }
    }

    private function validateData() {
        $this->validateEmail();
        $this->validatePassword();
    }

    private function validateEmail() {
        if (!filter_var($this->dto->email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email Invalido");
        }

        if (UserModel::findByEmail($this->dto->email)) {
            throw new Exception("Email ja Cadastrado");
        }

        if (strlen($this->dto->email) > 200) {
            throw new Exception("Email muito Longo");
        }

        if (strlen($this->dto->email) < 10) {
            throw new Exception("Email muito Curto");
        }
    }

    private function validatePassword() {
        if (strlen($this->dto->password) < 6) {
            throw new Exception("Senha muito Curta");
        }

        if ($this->dto->password !== $this->dto->confirmPassword) {
            throw new Exception("Senhas diferentes");
        }
    }
}
