<?php


namespace App\Services\Auth;

use App\Http\Resources\AuthResource;
use App\Models\User;

interface AuthServiceInterface
{
    public function register(string $name,string $email,string $password): AuthResource;
    public function login(string $email, string $password): AuthResource;
    public function refresh_token(string $refreshToken): AuthResource;
    //public function createTokens(User $user): array;
}