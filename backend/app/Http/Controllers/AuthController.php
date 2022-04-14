<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\UseCases\Auth\LoginUseCase;
use App\UseCases\Auth\RegisterUseCase;

class AuthController extends Controller
{
    /**
     * Register a new user
     * 
     * @param RegisterRequest $request
     * @param RegisterUseCase $useCase
     * 
     * @return AuthResource
     */
    public function register(RegisterRequest $request, RegisterUseCase $useCase): AuthResource {
        $newUser = $useCase(...$request->validated());
        return new AuthResource($newUser);
    }

    /**
     * Login a registered user
     * @param RegisterRequest $request
     * @param RegisterUseCase $useCase
     * 
     * @return AuthResource
     */
    public function login(LoginRequest $request, LoginUseCase $useCase): AuthResource {
        $userRegistered = $useCase(...$request->validated());
        return new AuthResource($userRegistered);
    }
}
