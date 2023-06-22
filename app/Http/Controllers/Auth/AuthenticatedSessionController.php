<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

/**
 * @group Authentication
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * Login.
     * This endpoint allows users to login.
     * @response {
     *  "user": {
     *      ....,
     *      "roles":[{
     *          ....
     *      }]
     *  },
     *  "token": "1cds1s64c...",
     * }
     * @response 422 {
     *      "message": "These credentials do not match our records.",
     *      "errors": {
     *          "email": [
     *              "These credentials do not match our records."
     *          ]
     *      }
     *  }
     */
    public function store(LoginRequest $request): JsonResponse{
        $user = $request->authenticate();
        $success['user'] = UserResource::make($user);
        $success['token'] = $user->createToken('token')->plainTextToken;
        return $this->success(
            message: "Login successful",
            data: $success,
        );
    }

    /**
     * @authenticated
     * Logout.
     * This endpoint allows users to logout
     */
    public function destroy(): JsonResponse{
        auth()->user()->currentAccessToken()->delete();
        return $this->success(
            message: "Logged out successful",
        );
    }
}
