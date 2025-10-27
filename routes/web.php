<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserModelController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PostController; 
use Illuminate\Support\Facades\Auth;

// --- Public/Landing Page Routes ---

// The main landing page shows recent blogs (data fetched by PostController)
Route::get('/', [PostController::class, 'welcome'])->name('welcome'); 
Route::get('/blogs', [PostController::class, 'index'])->name('blogs.index'); // All Published Blogs
Route::get('/blogs/{post}', [PostController::class, 'show'])->name('blogs.show'); // Single Post View

// Primary Routes
Route::get('/hello', function () {
    return view('hello');
});

Route::get('/features',[UserModelController::class,'features'])->name('features');


// --- Authentication Routes (Middleware 'guest' prevents logged-in users from seeing these) ---
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post')->middleware('guest');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.post')->middleware('guest');

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');


// --- Authenticated Routes (Middleware 'auth' requires login) ---
Route::middleware(['auth'])->group(function () {
    
    // The immediate post-login redirection point, which redirects to the dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home'); 

    // Dashboard (Shows user's queue/list of posts - PostController@dashboard)
    Route::get('/dashboard', [PostController::class, 'dashboard'])->name('dashboard'); 

    // Create Form
    Route::get('/dashboard/create', [PostController::class, 'create'])->name('posts.create');
    
    // Store Logic
    Route::post('/dashboard', [PostController::class, 'store'])->name('posts.store');

    // Edit Form
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    
    // Update Logic
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');

    // Delete Logic
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});