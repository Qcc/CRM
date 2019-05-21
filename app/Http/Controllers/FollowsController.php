<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Follow;
use App\Models\Record;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Auth;
use App\Http\Requests\FollowRequest;

class FollowsController extends Controller
{
    public function follow(Follow $follow)
    {
        $follows = $follow->with('company')->get();
        return view('pages.follow.follow',compact('follows'));
    }

    // 跟进客户
    public function show(Follow $follow)
    {
        $follows = $follow->with('company')->get();
        return view('pages.follow.show',compact('follows','follow'));
        
    }
    public function store(FollowRequest $request, Follow $follow)
    {
        // dd($request->all());
        // $data = Arr::except($request->all(), ['_token']);
        // $follow->fill(array_diff($data,array(null)));
        // $follow->save();
        $follow->fill($request->all());
        $follow->user_id = Auth::id();
        $follow->save();
        return back()->with('success', '客户信息保存完成!');
    }

    public function storeRecord(Request $request, Record $record)
    {
        if(strlen($request->content) < 38){
            return back()->withInput()->with('danger', '反馈结果不能少于10个字。');
        }
        $user = Auth::user();
        $author = "<p class='pr'>跟进人:".$user->name."</p>";
        $record->content = $request->content.$author;
        $record->user_id = Auth::id();
        $record->company_id = $request->company_id;
        $record->save();
        return back()->with('success', '客户信息保存完成!');
    }
}
