<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Berhasil login!');
        }

        return back()->with('error', 'Login gagal! Email atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function getProfile()
    {
        $userAuth = Auth::user()->profile;
        $profile = Profile::where('user_id', Auth::id())->first();
        if ($userAuth) {
            return view("profile.edit", compact('profile'));
        } else {
            return view("profile.create");
        }
    }
}
