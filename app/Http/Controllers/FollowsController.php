<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Follow;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Auth;

class FollowsController extends Controller
{
    public function follow(Company $company)
    {
        $user = Auth::user();
        $follows = Redis::smembers('target_'.$user->id);
        $companys = $company->find($follows);
        return view('pages.follow.follow',compact('companys'));
    }
}
