<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        $inputUsername = $request->input('email');


        Log::info('Login attempt for username: ' . $inputUsername);

        $user = User::where('username', $inputUsername)->first();


        if (!$user) {
            Log::warning('User not found: ' . $inputUsername);
            return back()->withErrors([
                'email' => 'Username tidak ditemukan.',
            ])->onlyInput('email');
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            Log::warning('Password mismatch for user: ' . $inputUsername);
            return back()->withErrors([
                'email' => 'Password salah.',
            ])->onlyInput('email');
        }

        Auth::login($user, $request->filled('remember'));

        $request->session()->regenerate();

        Log::info('Login successful for user: ' . $inputUsername . ' with role: ' . $user->role);

        return match ($user->role) {
            'admin' => redirect()->intended(route('admin.dashboard')),
            'kasir' => redirect()->intended(route('kasir.dashboard')),
            default => redirect()->intended('/'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}