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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FollowsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function follow(Follow $follow, Customer $customer, Record $record)
    {
        $user = Auth::user();
        $follows = $follow->where('user_id',$user->id)->with('company')->get();
        $recordsOfMonth = $record->where('user_id',$user->id)->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->get();
            // 本月拨打电话
        $callCountOfMonth = 0;
        // 本月有效商机
        $businessCountOfMonth = 0;
        foreach ($recordsOfMonth as $r) {
            if($r->familiar == true){
                $callCountOfMonth++;
            }
            if($r->feed == 1){
                $businessCountOfMonth++;
            }
        }
        // 本月客户
        $customersOfMonth = $customer->where('user_id',$user->id)->where('check',3)
        ->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->get();
        // 本月成交客户
        $cusCountOfMonth = 0;
        $moneyOfMonth = 0;
        // 本月成交金额
        foreach ($customersOfMonth as $c) {
            $cusCountOfMonth++;
            $moneyOfMonth += $c->contract_money;
        }

        // 上个月客户
        $customersOfLastMonth = $customer->where('user_id',$user->id)
        ->whereBetween('created_at',[Carbon::now()->startOfMonth()->subMonths(1),Carbon::now()->startOfMonth()->subMonths(1)->endOfMonth()])->get();
        // 上个月成交金额
        $moneyOfLastMonth = 0;
        foreach ($customersOfLastMonth as $c) {
            $moneyOfLastMonth += $c->contract_money;
        }
        
        // 缓存通知设置
		$notice = Cache::rememberForever('notice', function (){
            $n = \DB::table('settings')->where('name','notice')->first();
            return $n->data;
        });
        
        // 本月等级由上个月决定
        $thisMonth = howLevel($moneyOfLastMonth);
        // 下个月等级由本月决定
        $lastMonth = howLevel($moneyOfMonth);

        // 本月 业绩统计
        $achievement = [
            'callCountOfMonth' => $callCountOfMonth,
            'businessCountOfMonth' => $businessCountOfMonth,
            'cusCountOfMonth' => $cusCountOfMonth,
            'moneyOfMonth' => $moneyOfMonth,
            'levelOfMonth' => $thisMonth->name,
            'commissionOfMonth' => $thisMonth->commission,
            'nextMonthLevel' => $lastMonth->name,
            'nextMonthCommission' => $lastMonth->commission,
            'notice' => $notice,
        ];
        // 预约联系 提前1天提醒
        $schedules = $follow->with('company')->where('user_id',$user->id)->where('schedule_at','<',Carbon::now()->addday(3))->orderBy('schedule_at','asc')->get();
        // 跟进到期 提前10天提醒
        $countdowns = $follow->with('company')->where('user_id',$user->id)->where('countdown_at','<',Carbon::now()->addDay(10))->orderBy('countdown_at','asc')->get();
        // 老客户维系 提前5天提醒
        $relationships = $customer->with('company')->where('user_id',$user->id)->where('check',3)->where('relationship_at','<',Carbon::now()->addDay(5))->orderBy('relationship_at','asc')->get();
        // 售后续费到期 提前30天提醒
        $expireds = $customer->with('company')->where('user_id',$user->id)->where('check',3)->where('expired_at','<',Carbon::now()->addDay(30))->orderBy('expired_at','asc')->get();

        return view('pages.follow.follow',compact('follows', 'achievement', 'schedules', 'countdowns', 'relationships', 'expireds'));
    }

    // 跟进客户
    public function show(Follow $follow)
    {
        $this->authorize('update', $follow);

        // 缓存商机管理设置
		$business = Cache::rememberForever('business', function (){
            $b = \DB::table('settings')->where('name','business')->first();
            return json_decode($b->data);
        });
        if($follow->user_id == Auth::id()){
            $follows = $follow->where('user_id',Auth::id())->with('company')->get();
            return view('pages.follow.show',compact('follows','follow','business'));
        }else{
            return abort(404);
        }
        
        
    }
    public function store(Request $request, Follow $follow)
    {
        
        if($follow->user_id == Auth::id()){
            $follow->fill($request->all());
            $follow->user_id = Auth::id();
            $follow->save();
            return back()->with('success', '客户信息保存完成!');
        }else{
            return back()->with('danger', '该客户不属于你，请联系主管!');

        }
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
        $this->authorize('update', $follow);
        // 缓存商机管理设置
		$business = Cache::rememberForever('business', function (){
            $b = \DB::table('settings')->where('name','business')->first();
            return json_decode($b->data);
        });
        if($follow->delayCount > 0 && $business->delay){
            $follow->update(['countdown_at'=>Carbon::parse($follow->countdown_at)->addDays($business->picOfdays),'delayCount'=>$follow->delayCount--]);
            return back()->with('success', '延期成功,请尽快促成成交!');
        }
        return back()->with('danger', '延期次数已经用完!');
    }

    // 老客户订单续签
    public function agent(Request $request, Follow $follow)
    {
        $follow = Follow::withTrashed()->find($request->follow_id);
        $this->authorize('update', $follow);
        if($follow->deleted_at != null){
            $follow->restore();
        }
        if(!$follow->customer_id){
            $follow->customer_id = $request->customer_id;
            $follow->save();
        }
        return redirect()->route('follow.show',$follow->id)->with('success', '创建续费订单成功，请继续跟进客户');
    }
}
