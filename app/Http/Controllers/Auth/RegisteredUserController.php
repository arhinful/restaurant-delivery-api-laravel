<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    public function store(RegisterRequest $request): JsonResponse {
        DB::beginTransaction();
        try {
            $user = UserService::store($request->validated());
            event(new Registered($user));
            Auth::login($user);
            return $this->successCreated(data: $user, message: "Your account has been created successfully");
        } catch (\Exception $exception){
            return $this->errorOccurred($exception->getMessage());
        }
    }
}
