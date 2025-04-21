<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return Inertia::render('Auth/Login');
    }

    public function authUser(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255'
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($data, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('home', absolute: false))->with('notification', [
                'type' => 'success',
                'message' => 'Вы успешно авторизовались'
            ]);
        }

        return back()->with('notification', [
            'type' => 'error',
            'message' => 'Предоставленные учетные данные не соответствуют нашим записям'
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
