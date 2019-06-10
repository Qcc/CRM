<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

use App\Models\Company;
use App\Models\Follow;
use App\Models\Customer;
use App\Models\Record;
use App\Models\User;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['root','report']]);
    }
    public function root()
    {
        return view('pages.root');
    }
    
    public function show(Request $request)
    {
        // 缓存业绩等级设置
		$level = Cache::rememberForever('level', function (){
            $l = \DB::table('settings')->where('name','level')->first();
            return json_decode($l->data); 
        });
        // 缓存通知设置
		$notice = Cache::rememberForever('notice', function (){
            $n = \DB::table('settings')->where('name','notice')->first();
            return $n->data;
        });
        // 缓存商机管理设置
		$business = Cache::rememberForever('business', function (){
            $b = \DB::table('settings')->where('name','business')->first();
            return json_decode($b->data);
        });
        // 缓存老客户维系设置
		$customer = Cache::rememberForever('customer', function (){
            $c = \DB::table('settings')->where('name','customer')->first();
            return json_decode($c->data);
        });
        // 缓存报表设置
		$report = Cache::rememberForever('report', function (){
            $r = \DB::table('settings')->where('name','report')->first();
            return json_decode($r->data);
        });
        return view('pages.system.setting',compact('level','notice','business', 'customer', 'report'));
    }
    
    public function store(Request $request)
    {
        if($request->type == 'notice'){
            \DB::table('settings')->where('name','notice')->update(['data' => $request->notice]);
            // 清除通知缓存
            Cache::forget('notice');
        }else if($request->type == 'business'){
            $business = [
                'days' => $request->days,
                'delay' => $request->delay?1:0,
                'pics' => $request->pics,
                'picOfdays' => $request->picOfdays, 
            ];
            \DB::table('settings')->where('name','business')->update(['data' => json_encode($business)]);
            // 清除商机管理等级缓存
            Cache::forget('business');
        }else if($request->type == 'level'){
            $level = [
                'level_1' => [
                    'performance' => $request->level_1_performance,
                    'name' => $request->level_1_name,
                    'commission' => $request->level_1_commission,
                    'call' => $request->level_1_call,
                    'effective' => $request->level_1_effective,
                ],
                'level_2' => [
                    'performance' => $request->level_2_performance,
                    'name' => $request->level_2_name,
                    'commission' => $request->level_2_commission,
                    'call' => $request->level_2_call,
                    'effective' => $request->level_2_effective,
                ],
                'level_3' => [
                    'performance' => $request->level_3_performance,
                    'name' => $request->level_3_name,
                    'commission' => $request->level_3_commission,
                    'call' => $request->level_3_call,
                    'effective' => $request->level_3_effective,
                ],
                'level_4' => [
                    'performance' => $request->level_4_performance,
                    'name' => $request->level_4_name,
                    'commission' => $request->level_4_commission,
                    'call' => $request->level_4_call,
                    'effective' => $request->level_4_effective,
                ],
                'level_5' => [
                    'performance' => $request->level_5_performance,
                    'name' => $request->level_5_name,
                    'commission' => $request->level_5_commission,
                    'call' => $request->level_5_call,
                    'effective' => $request->level_5_effective,
                ],
                'level_6' => [
                    'performance' => $request->level_6_performance,
                    'name' => $request->level_6_name,
                    'commission' => $request->level_6_commission,
                    'call' => $request->level_6_call,
                    'effective' => $request->level_6_effective,
                ],
            ];
            \DB::table('settings')->where('name','level')->update(['data' => json_encode($level)]);
            // 清除业绩等级缓存
            Cache::forget('level');
        }else if($request->type == 'report'){
            $report = [
                'employee' => $request->employee, 
                'inbox' => $request->inbox, 
                'repeat' => [
                    'day' => isset($request->repeat['day'])?1:0,
                    'week' => isset($request->repeat['week'])?1:0,
                    'month' => isset($request->repeat['month'])?1:0,
                ] 
            ];
            \DB::table('settings')->where('name','report')->update(['data' => json_encode($report)]);
            // 清除报表发送缓存
            Cache::forget('report');
        }else if($request->type == 'customer'){
            $customer = [
                'days' => $request->days,
            ];
            \DB::table('settings')->where('name','customer')->update(['data' => json_encode($customer)]);
            // 清除商机管理等级缓存
            Cache::forget('customer');
        }
        return back()->with('success', '设置保存完成!');;
    }
    public function sendReport(Request $request)
    {   
        // 立即发送报表
        if($request->scope != ''){
            $date = explode('~',$request->scope);
            $start = Carbon::parse($date[0]);
            $end = Carbon::parse($date[1])->endOfDay();
            dd([$start,$end]);
        }else{
            return back()->with('danger', '请选择统计日期时间范围!');
        }
    }

    // 发送报表
    public function report(Request $request)
    {   
        $inbox = "kevin@kouton.com";
        $ids = "1,2,3";
        $scope = "2019-06-01 00:00:00 ~ 2019-06-31 00:00:00";
        $date = explode('~',$scope);
        $start = Carbon::parse($date[0]);
        $end = Carbon::parse($date[1])->endOfDay();
        $users = explode(',',$ids);
        // 统计数据
        $statistics = [];
        // 明细数据
        $details = [];
        foreach ($users as $index => $user) {
            $user = User::find($user);
            // 客户
            $customers = Customer::where('user_id',$user->id)->with(['company:id,name'])->where('check','complate')
            ->whereBetween('created_at',[$start,$end])->get();
            // 成交客户
            $cusCount = 0;
            $money = 0;
            // 成交金额
            foreach ($customers as $c) {
                $cusCount++;
                $money += $c->contract_money;
            }

            // 跟进中的客户
            $follows = Follow::where('user_id',$user->id)->with(['company:id,name'])->get();

            // 拨打电话统计
            $records = Record::where('user_id',$user->id)->with(['company:id,name'])->whereBetween('created_at',[$start,$end])->get();
            // 拨打电话
            $callCount = 0;
            // 有效商机
            $businessCount = 0;
            foreach ($records as $r) {
                if($r->familiar == true){
                    $callCount++;
                }
                if($r->feed == 'lucky'){
                    $businessCount++;
                }
            }
            // 详细信息
            $employee = (object)[];
            $employee->user = $user;
            $employee->customers = $customers;
            $employee->follows = $follows;
            $employee->records = $records;
            array_push($details,$employee);

            // 统计数据
            $line = (object)[];
            $line->id = $index + 1;
            $line->name = $user->name;
            $line->callCount = $callCount;
            $line->businessCount = $businessCount;
            $line->busEfficiency = $callCount == 0 ? 0: round($businessCount / $callCount,3)*100;
            $line->cusCount = $cusCount;
            $line->cusEfficiency = $callCount == 0 ? 0:round($cusCount / $businessCount,3)*100;            
            $line->money = $money;
            array_push($statistics, $line);
        }
        $total = (object)[];
        $total->name = "合计";
        $total->total = 0;
        foreach ($statistics as $ele) {
            $total->total += $ele->money;
        }       
        array_push($statistics, $total);
        // 根据业绩排序
        // usort($statistics, function($a, $b){
        //     return $a->money > $b->money;
        // });
        return view('emails.report',compact('scope', 'statistics','details'));
    }
}
