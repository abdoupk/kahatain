<?php

namespace App\Http\Controllers\V1\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class LogoutController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        /** @var PersonalAccessToken $token */
        $token = $request->user()?->currentAccessToken();

        $token->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
