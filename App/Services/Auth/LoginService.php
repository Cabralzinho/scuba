<?php

namespace App\Services\Auth;

use App\Dtos\LoginUserDto;
use App\Models\UserModel;

class LoginService {
    public function __construct(private UserModel $userModel) {}

    public function login(LoginUserDto $dto) {
        $this->validateData($dto);

        $user = $this->userModel->findByEmail($dto->email);

        if (empty($user)) {
            throw new \Exception("Usuário não existe.");
        }

        $isPasswordMatch = password_verify($dto->password, $user["password"]);

        if (!$isPasswordMatch) {
            throw new \Exception("Senha inválida.");
        }

        return $user;
    }

    private function validateData(LoginUserDto $dto) {
        $this->validateEmail($dto->email);
        $this->validatePassword($dto->password);
    }

    private function validateEmail(string $email) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Email inválido.");
        }
    }

    private function validatePassword(string $password) {
        if(strlen($password) < 6) {
            throw new \Exception("Senha deve conter pelo menos 6 caracteres.");
        }
    }
}