<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/dashboard');
            }
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'message' => 'incorrect credentials',
        ]);
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:3|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        unset($validated['password_confirmation']);
        $validated['password'] = Hash::make($validated['password']); // Hash the password
        $validated['role'] = 'user'; // Add default role
        try {
            User::create($validated);
            return redirect()->intended('/login');
        } catch (\Exception $e) {
            return back()->withErrors([
                'message' => 'Registration failed, please try again later.'
            ]);
        }
    }

}
