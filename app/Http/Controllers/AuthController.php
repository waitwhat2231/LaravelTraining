<?php

namespace App\Http\Controllers;

use App\Http\Requests\RefreshTokenRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Resources\AuthResource;
use App\Services\Auth\AuthServiceInterface;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
        public function __construct(
        private AuthServiceInterface $authService
    ) {}
    public function register(RegisterRequest $request){
        $validated= (object)$request->validated();
        return $this->authService->register($validated->name,$validated->email,$validated->password);
    }
    public function login(LoginRequest $request){
        $validated= (object)$request->validated();
        return $this->authService->login($validated->email,$validated->password);
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
        return $this->authService->refresh_token($validated->refresh_token);
    }
  
}
