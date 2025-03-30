<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $socialUser->getEmail())->first();
            
            if ($user) {
                if (empty($user->google_id)) {
                    $user->update([
                        "google_id" => $socialUser->getId()
                    ]);
                }
            } else {
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt(str()->random(16)),
                    "google_id" => $socialUser->getId(),
                ]);
            }

            Auth::login($user);

            return redirect()->intended('/')->with('success', 'Вы успешно авторизовались');
            
        } catch (\Exception $e) {
            \Log::error('Social Auth Error: ' . $e->getMessage());
            return redirect()->route('auth')
                ->with('error', 'Произошла ошибка при авторизации через Google');
        }
    }
}