<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InvalidTokenException extends Exception
{
    public function __construct($message = "Invalid Token", $code = 401){
        parent::__construct($message, $code);
    }
  public function render(Request $request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], 401);
    }
}
