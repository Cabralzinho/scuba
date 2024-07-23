<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model {
    protected $table = 'users';

    public static function registerUser(string $name, string $email, string $password) {
        return self::insert([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);
    }

    public static function findByEmail($email) {
        return self::where('email', $email)->first();
    }
}
