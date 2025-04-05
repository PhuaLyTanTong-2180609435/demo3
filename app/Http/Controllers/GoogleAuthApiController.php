<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\RoleDetails;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleAuthApiController extends Controller
{
    // Chuyển hướng người dùng đến Google để xác thực
    public function redirectToGoogle()
    {
        $url = Socialite::driver('google_api')->stateless()->redirect()->getTargetUrl();
        return response()->json(['url' => $url]);
    }

    // Xử lý phản hồi từ Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google_api')->stateless()->user();


            $user = Account::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'accountName' => $googleUser->name,
                    'name' => $googleUser->name,
                    'password' => bcrypt('default_password'), // Đặt mật khẩu tạm thời
                    'description' => 'Đăng nhập bằng Google',
                    'timeCreated' => now(),
                ]
            );
            RoleDetails::updateOrInsert(
                ['idAccount' => $user->idAccount, 'idRole' => 1],
                ['timeCreated' => now()]
            );
            // Tạo token đăng nhập
            $token = auth('api')->login($user);

            return response()->json([
                'message' => 'Đăng nhập thành công',
                'token' => $token,

            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            \Log::error('Google Auth Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Authentication failed',
                'message' => $e->getMessage()
            ], 401);
        }
    }
}
