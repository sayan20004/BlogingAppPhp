<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    
    public function showRegistrationForm()
    {
        return view('registration'); 
    }

    
    public function register(Request $request)
    {

        $request->validate([

            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'dob' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:20'],
            

            'village' => ['nullable', 'string', 'max:255'],
            'post' => ['nullable', 'string', 'max:255'],
            'police_station' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],


            'password' => [
                'required', 
                'confirmed', 
                Password::defaults()
            ],
        ]);
        

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'dob' => $request->dob,
            'phone' => $request->phone,
            'village' => $request->village,
            'post' => $request->post,
            'police_station' => $request->police_station,
            'district' => $request->district,
        ]);


        Auth::login($user);


        return redirect()->route('home')->with('success', 'Registration successful! Welcome aboard.');
    }
}