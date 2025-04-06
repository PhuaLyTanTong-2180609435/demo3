<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\RoleDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class GoogleAuthApiController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        $redirectUrl = $request->query('redirect_url');

        if (!$redirectUrl) {
            return response()->json(['error' => 'Thiếu redirect_url'], 400);
        }

        $state = Str::random(32);
        Cache::put("google_redirect_{$state}", $redirectUrl, now()->addMinutes(5));

        $url = Socialite::driver('google_api')
            ->stateless()
            ->with(['state' => $state])
            ->redirect()
            ->getTargetUrl();

        return response()->json(['url' => $url]);
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $state = $request->query('state');
            $redirectUrl = Cache::pull("google_redirect_{$state}");

            if (!$redirectUrl) {
                \Log::error("Invalid or expired state: {$state}");
                return response()->json(['error' => 'Invalid or expired state'], 400);
            }

            $googleUser = Socialite::driver('google_api')->stateless()->user();

            $user = Account::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'accountName' => $googleUser->name,
                    'name' => $googleUser->name,
                    'password' => bcrypt('default_password'),
                    'description' => 'Đăng nhập bằng Google',
                    'timeCreated' => now(),
                ]
            );

            RoleDetails::updateOrInsert(
                ['idAccount' => $user->idAccount, 'idRole' => 1],
                ['timeCreated' => now()]
            );

            $token = auth('api')->login($user);

            // Redirect về redirectUrl của FE với token trong query
            return redirect()->to("{$redirectUrl}?token={$token}");
        } catch (\Exception $e) {
            \Log::error('Google Auth Error: ' . $e->getMessage());
            // Redirect về FE với lỗi (thay bằng domain/port của FE)
            $fallback = 'http://localhost:8080/login-failed'; // Thay bằng port của FE
            return redirect()->to("{$fallback}?error=" . urlencode($e->getMessage()));
        }
    }
}
