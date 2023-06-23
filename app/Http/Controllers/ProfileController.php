<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    /**
     * Fetch Authenticated User.
     *
     * This endpoint allows a user to register
     *
     * @group Authentication
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User with=roles
     */
    public function showMe(): JsonResponse{
        $user = UserResource::make(auth()->user()->with('roles'));
        return $this->successRead($user);
    }
}
