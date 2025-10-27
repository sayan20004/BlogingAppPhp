<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserModelController extends Controller
{

    public function show(){

        return view('registration');
    }
    public function features(){

        return view('features');
    }
}
