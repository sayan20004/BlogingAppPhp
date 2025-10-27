<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    
    public function showLoginForm()
    {
        return view('login');
    }


    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        $remember = $request->filled('remember');


        if (Auth::attempt($credentials, $remember)) {

            $request->session()->regenerate();


            return redirect()->intended(route('home'));
        }


        throw ValidationException::withMessages([
            'email' => __('These credentials do not match our records.'),
        ]);
    }
}