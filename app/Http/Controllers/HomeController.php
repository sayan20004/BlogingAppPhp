<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Redirects the user from /home to their post queue dashboard.
     */
    public function index()
    {
        // FIX: Redirects the user to the named 'dashboard' route, 
        // which runs PostController@dashboard and shows the post queue.
        return view('home'); 
    }
}