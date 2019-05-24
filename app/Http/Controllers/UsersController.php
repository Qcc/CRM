<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Smtp;
use Auth;

class UsersController extends Controller
{
    public function setStore()
    {
        dd();
    }

    public function settings(Smtp $smtp)
    {   $user = Auth::user();
        $smtps = $smtp->where('user_id',$user->id)->get();
        return view('users.settings',compact('smtps'));
    }
}
