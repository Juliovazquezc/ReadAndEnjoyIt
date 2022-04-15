<?php

namespace App\UseCases\Auth;

use App\Exceptions\BadCredentialsException;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginUseCase 
{
    /**
     * Login a user registered
     * @param $email
     * @param $password
     * 
     * @return User
     */
    public function __invoke(string $email, $password): User {
        if (!Auth::attempt(['email'=> $email, 'password'=> $password])) {
            throw new BadCredentialsException(__('auth.exceptions.bad_credentials'), Response::HTTP_FORBIDDEN);
        }

        $userRegistered = User::where('email', $email)->first();
        return $userRegistered;
    }
}