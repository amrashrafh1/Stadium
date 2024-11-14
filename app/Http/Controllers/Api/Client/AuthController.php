<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\LoginRequest;
use App\Http\Requests\Api\Client\RegisterRequest;
use App\Http\Resources\API\Client\AuthResource;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ResponseTrait;

    public function __construct(protected UserService $userService)
    {

    }

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            // create or restore user if exists
            $user = $this->userService->createOrRestoreUser($request->validated());
            // generate and save otp
            $this->userService->generateAndSaveOtp($user);
            DB::commit();
            return $this->successResponse(['user' => new \App\Http\Resources\API\Client\AuthResource($user)], __('auth.otpSent'));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->errorResponse(__('error.someThingWrong'), 422);
        }

    }

    public function verifyAccount(\App\Http\Controllers\Api\Client\VerifyOtpRequest $request)
    {
        DB::beginTransaction();
        try {
            // get user
            $user = User::whereRole('client')->where('email', $request->email)->first();
            // verify otp and get token
            $token = $this->userService->otpVerify($user, $request->validated());
            // if token is error return an error
            if ($token instanceof JsonResponse) {
                return $token;
            }

            DB::commit();
            return $this->successResponse(['user' => new AuthResource($user), 'token' => $token], __('auth.otpSent'));
        } catch (\Exception $e) {
            DB::rollback();
            \Log::info($e->getMessage());
            return $this->errorResponse(__('error.someThingWrong'), 422);
        }

    }

    public function login(LoginRequest $request)
    {
        try {
            // get user by email
            $user = User::whereRole('client')->where('email', $request->email)->first();
            // check if user exists
            if (!$user) {
                DB::rollBack();
                return $this->errorResponse(__('auth.userNotFound'), 422);
            }
            // check if password is correct
            if (!Hash::check($request->password, $user->password)) {
                return $this->errorResponse(__('auth.failed'), 401);
            }
            // check if user is verified
            if (!$user->email_verified_at) {
                DB::rollBack();
                return $this->errorResponse(['message' => __('auth.notVerified'), 'user' => new AuthResource($user), 'is_verified' => false], 422);
            }
            // create access Token
            $token = $user->createToken('stadium')->accessToken;
            data_set($user, 'token', $token);
            DB::commit();
            return $this->successResponse(['user' => new AuthResource($user), 'token' => $token], __('auth.welcome'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('error.someThingWrong'), 422);
        }

    }


    public function logout()
    {
        try {
            auth()->user()->tokens()->delete();
            return $this->successResponse([], __('auth.loggedOut'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('error.someThingWrong'), 422);
        }

    }

}
