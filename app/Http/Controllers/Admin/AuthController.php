<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function loginCheck(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (!Auth::check()) {
                return redirect()->back()->with('error', 'You do not have admin access.');
            } else {
                return redirect()->route('admin-service-dashboard');
            }
        } else {
            return redirect()->back()->withInput()->withErrors(['email' => 'Invalid email or password']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
