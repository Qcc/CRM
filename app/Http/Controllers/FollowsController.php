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
    public function follow(Company $company)
    {
        $user = Auth::user();
        $follows = Redis::smembers('target_'.$user->id);
        $companys = $company->find($follows);
        return view('pages.follow.follow',compact('companys'));
    }

    // 跟进客户
    public function show(Request $request, Company $company)
    {
        $user = Auth::user();
        if(Redis::sismember('target_'.$user->id,$request->company->id)){
            $follows = Redis::smembers('target_'.$user->id);
            $companys = $company->find($follows);
            return view('pages.follow.show',compact('companys','company'));
        }else{
            return abort(404);
        }
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
        // dd($request->all());
        $user = Auth::user();
        if(Redis::sismember('target_'.$user->id,$request->company_id)){
            if(strlen($request->content) < 38){
                return back()->withInput()->with('danger', '反馈结果不能少于10个字。');
            }
            $author = "<p class='pr'>跟进人:".$user->name."</p>";
            $record->content = $request->content.$author;
            $record->user_id = Auth::id();
            $record->company_id = $request->company_id;
            $record->save();
            return back()->with('success', '客户信息保存完成!');
        }else{
            return abort(404);
        }
    }
}
