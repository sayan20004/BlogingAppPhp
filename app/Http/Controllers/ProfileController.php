<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule; 

class ProfileController extends Controller
{
    
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    
    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'dob' => ['nullable', 'date'],
            'phone' => ['nullable', 'string', 'max:20'],
            'village' => ['nullable', 'string', 'max:255'],
            'post' => ['nullable', 'string', 'max:255'],
            'police_station' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // 2MB max for profile image

            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'required_with:current_password', 'confirmed', Password::defaults()],
        ]);

        // Handle Profile Image Upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if it exists
            if ($user->profile_image_path) {
                Storage::disk('public')->delete($user->profile_image_path);
            }
            // Store the new image in 'profile_images' directory within 'public' disk
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $validatedData['profile_image_path'] = $imagePath;
        }

        // Handle Password Update (Only if new password is provided)
        if (!empty($validatedData['new_password'])) {
            $validatedData['password'] = Hash::make($validatedData['new_password']);
        }
        // Remove password fields if not updating password to prevent accidental override
        unset($validatedData['current_password'], $validatedData['new_password'], $validatedData['new_password_confirmation']);



        unset($validatedData['profile_image']);

        $user->update($validatedData);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}