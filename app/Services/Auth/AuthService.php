<?php

namespace App\Services\Auth;

use App\Exceptions\InvalidTokenException;
use App\Http\Requests\RefreshTokenRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Resources\AuthResource;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    public function register(string $name,string $email,string $password): AuthResource
    {
       $author=Author::create([
            "name"=> $name,
            "email"=> $email,
            "password"=> Hash::make($password),
        ]);
        return new AuthResource( $this->issueTokens($author));
    }

    public function login(string $email,string $password):AuthResource   {
          $author = Author::where('email', $email)->first();

        if (! $author || ! Hash::check($password, $author->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        return new AuthResource( $this->issueTokens($author));
    }
    public function refresh_token(string $refreshToken): AuthResource{
                $token = \Laravel\Sanctum\PersonalAccessToken::findToken(
            $refreshToken
        );
        
        if (! $token || $token->name !== 'refresh-token') {
           throw new InvalidTokenException();
        }

        $author = $token->tokenable;

        // Revoke old access tokens
        $author->tokens()
            ->where('name', 'access-token')
            ->delete();

        return new AuthResource( $this->issueTokens($author));
    }
  protected function issueTokens(Author $author){
        $author->tokens()->delete();
        $accessToken = $author->createToken(
            'access-token',
            ['*'],
            now()->addMinutes(15)
        )->plainTextToken;

        $refreshToken = $author->createToken(
            'refresh-token',
            ['refresh'],
            now()->addDays(7)
        )->plainTextToken;

         return [
        'access_token'  => $accessToken,
        'refresh_token' => $refreshToken,
    ];
    }
}