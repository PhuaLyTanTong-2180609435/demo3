<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\Account;
use App\Models\Role;
use App\Models\RoleDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class GoogleAuthController extends Controller
{
    /**
     * Điều hướng người dùng đến Google OAuth
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Xử lý callback từ Google
     */
    public function callback()
    {

        $googleUser = Socialite::driver('google')->user();

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

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    /**
     * Đăng xuất người dùng
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
