<?php

namespace App\Http\Controllers;

use App\Http\Requests\RefreshTokenRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Resources\AuthResource;
use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $validated= (object)$request->validated();
        $author=Author::create([
            "name"=> $validated->name,
            "email"=> $validated->email,
            "password"=> Hash::make($validated->password),
        ]);
        return new AuthResource( $this->issueTokens($author));
    }
    public function login(LoginRequest $request){
        $validated= (object)$request->validated();
  $author = Author::where('email', $validated->email)->first();

        if (! $author || ! Hash::check($validated->password, $author->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        return new AuthResource( $this->issueTokens($author));
    }
    public function logout(LogoutRequest $request){
        $request->user()->tokens()->delete();
          return response()->json([
        'message' => 'Logged out successfully',
    ]);
    }
       public function refresh(RefreshTokenRequest $request)
    {
        $validated=(object)$request->validated();
        $token = \Laravel\Sanctum\PersonalAccessToken::findToken(
            $validated->refresh_token
        );
        
        if (! $token || $token->name !== 'refresh-token') {
            return response()->json(['message' => 'Invalid refresh token'], 401);
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
