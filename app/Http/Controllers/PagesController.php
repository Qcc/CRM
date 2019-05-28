<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function root()
    {
        return view('pages.root');
    }
    
    public function show(Request $request)
    {
        return view('pages.system.setting');
    }
}
