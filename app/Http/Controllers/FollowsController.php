<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Follow;
use App\Models\Customer;
use App\Models\Record;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Auth;
use App\Http\Requests\FollowRequest;

class FollowsController extends Controller
{
    public function follow(Follow $follow, Customer $customer, Record $record)
    {
        $user = Auth::user();
        $follows = $follow->with('company')->get();
        $recordsOfMonth = $record->where('user_id',$user->id)->whereBetween('created_at',[Carbon::now()->firstOfMonth(),Carbon::now()->lastOfMonth()->addDays(1)])->get();
            // 本月拨打电话
        $callCountOfMonth = 0;
        // 本月发送邮件
        $emailCountOfMonth = 0;
        // 本月有效商机
        $businessCountOfMonth = 0;
        foreach ($recordsOfMonth as $r) {
            if($r->feed == 'email'){
                $emailCountOfMonth++;
            }
            if($r->familiar == true){
                $callCountOfMonth++;
            }
            if($r->feed == 'lucky'){
                $businessCountOfMonth++;
            }
        }
        $customersOfMonth = $customer->where('user_id',$user->id)
        ->whereBetween('created_at',[Carbon::now()->firstOfMonth(),Carbon::now()->lastOfMonth()->addDays(1)])->get();
        // 本月成交客户
        $cusCountOfMonth = 0;
        $moneyOfMonth = 0;
        // 本月成交金额
        foreach ($customersOfMonth as $c) {
            $cusCountOfMonth++;
            $moneyOfMonth += $c->money;
        }
        // 当天
        $recordsOfDay = $record->where('user_id',$user->id)
            ->whereBetween('created_at',[Carbon::now()->today(),Carbon::now()->tomorrow()])->get();
        // 当天拨打电话
        $callCountOfDay = 0;
        // 当天发送邮件
        $emailCountOfDay = 0;
        // 当天有效商机
        $businessCountOfDay = 0;
        foreach ($recordsOfDay as $r) {
            if($r->feed == 'email'){
                $emailCountOfDay++;
            }
            if($r->familiar == true){
                $callCountOfDay++;
            }
            if($r->feed == 'lucky'){
                $businessCountOfDay++;
            }
        }
        $customersOfDay = $customer->where('user_id',$user->id)
        ->whereBetween('created_at',[Carbon::now()->firstOfMonth(),Carbon::now()->lastOfMonth()->addDays(1)])->get();
        // 当天成交客户
        $cusCountOfDay = 0;
        $moneyOfDay = 0;
        // 当天成交金额
        foreach ($customersOfDay as $c) {
            $cusCountOfDay++;
            $moneyOfDay += $c->money;
        }
        // 本月 当天 业绩统计
        $achievement = [
            'callCountOfMonth' => $callCountOfMonth,
            'emailCountOfMonth' => $emailCountOfMonth,
            'businessCountOfMonth' => $businessCountOfMonth,
            'cusCountOfMonth' => $cusCountOfMonth,
            'moneyOfMonth' => $moneyOfMonth,
            'callCountOfDay' => $callCountOfDay,
            'emailCountOfDay' => $emailCountOfDay,
            'businessCountOfDay' => $businessCountOfDay,
            'cusCountOfDay' => $cusCountOfDay,
            'moneyOfDay' => $moneyOfDay,
        ];
        return view('pages.follow.follow',compact('follows', 'achievement'));
    }

    // 跟进客户
    public function show(Follow $follow)
    {
        $follows = $follow->with('company')->get();
        
        return view('pages.follow.show',compact('follows','follow'));
        
    }
    public function store(Request $request, Follow $follow)
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
        return back()->with('success', '客户跟进反馈保存成功!');
    }

    public function delay(Follow $follow)
    {
        if($follow->delayCount > 0){
            $follow->update(['countdown'=>Carbon::parse($follow->countdown)->addDays(10),'delayCount'=>$follow->delayCount--]);
            return back()->with('success', '延期成功!');
        }
        return back()->with('danger', '延期次数已经用完!');
    }
}
