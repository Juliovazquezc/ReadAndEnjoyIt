<?php

namespace App\UseCases\Auth;

use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUseCase 
{
    /**
     * Register a new user in our app
     * @param $name
     * @param $email
     * @param $password
     * 
     * @return User
     */
    public function __invoke(string $name, string $email, string $password): User {
        $newUser = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        return $newUser;
    }
}