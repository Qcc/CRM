<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Smtp;

class UsersController extends Controller
{
    public function setStore()
    {
        dd();
    }

    public function settings(Smtp $smtp)
    {
        $smtps = $smtp->get();
        return view('users.settings',compact('smtps'));
    }
}
