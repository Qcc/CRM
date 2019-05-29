<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PagesController extends Controller
{
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
        return view('pages.system.setting',compact('level','notice','business'));
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
                    'commission' => $request->level_1_commission
                ],
                'level_2' => [
                    'performance' => $request->level_2_performance,
                    'name' => $request->level_2_name,
                    'commission' => $request->level_2_commission,
                ],
                'level_3' => [
                    'performance' => $request->level_3_performance,
                    'name' => $request->level_3_name,
                    'commission' => $request->level_3_commission,
                ],
                'level_4' => [
                    'performance' => $request->level_4_performance,
                    'name' => $request->level_4_name,
                    'commission' => $request->level_4_commission,
                ],
                'level_5' => [
                    'performance' => $request->level_5_performance,
                    'name' => $request->level_5_name,
                    'commission' => $request->level_5_commission,
                ],
                'level_6' => [
                    'performance' => $request->level_6_performance,
                    'name' => $request->level_6_name,
                    'commission' => $request->level_6_commission,
                ],
            ];
            \DB::table('settings')->where('name','level')->update(['data' => json_encode($level)]);
            // 清除业绩等级缓存
            Cache::forget('level');
        }
        return back()->with('success', '设置保存完成!');;
    }

}
