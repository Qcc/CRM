<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class UsersController extends Controller
{
    public function setStore()
    {
        dd();
    }

    public function settings()
    {   $user = Auth::user();
        return view('users.settings');
    }
}
