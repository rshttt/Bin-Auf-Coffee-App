<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function view() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/admin')
                ->with('message', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Wrong password or Email. Try again or click Forgot to reset it.',
        ])->onlyInput('email');
    }

    public function logout() {
        Auth::guard('admin')->logout();
        
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/'); 
    }
}