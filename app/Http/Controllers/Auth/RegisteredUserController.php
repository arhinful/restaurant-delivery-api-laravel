<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


/**
 * @group Authentication
 */
class RegisteredUserController extends Controller
{
    /**
     * Register New User.
     *
     * This endpoint allows a user to register
     *
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     */
    public function store(RegisterRequest $request): JsonResponse {
        DB::beginTransaction();
        try {
            $user = UserService::store($request->validated());
            event(new Registered($user));
            $user = UserResource::make($user);
            return $this->successCreated(
                data: $user, message:
                "Your account has been created successfully"
            );
        } catch (\Exception $exception){
            return $this->errorOccurred($exception->getMessage());
        }
    }
}
