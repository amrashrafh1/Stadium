<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;

class UserService
{
    use ResponseTrait;

    public function createOrRestoreUser($data): User
    {
        $user = User::where('email', $data['email'])->whereRole('client')->withTrashed()->first();

        if ($user) {
            $user->restore();
        } else {
            $user = User::create($data);
        }
        return $user;
    }

    public function generateAndSaveOtp(User $user): int
    {
        $otp = 1234; //mt_rand(1000, 9999);
        $user->update(['otp' => $otp]);
        return $otp;
    }

    public function otpVerify($user, $data)
    {

        if (!$user) {
            DB::rollback();
            return $this->errorResponse(__('auth.userNotFound'), 404);
        }
        if ($user->otp != $data['otp']) {
            DB::rollback();
            return $this->errorResponse(__('auth.invalidOtp'), 401);
        }

        $user->update(['otp' => null, 'email_verified_at' => now()]);
        $token = $user->createToken('stadium')->accessToken;
        data_set($user, 'token', $token);
        return $token;

    }
}
