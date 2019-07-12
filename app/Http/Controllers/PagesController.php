<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Jobs\SendReport;
use Illuminate\Support\Facades\Log;
use App\Handlers\ImageUploadHandler;
use App\Models\Edm;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['root','receiveEmailCount','emailClick']]);
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
        // 缓存报表设置
		$report = Cache::rememberForever('report', function (){
            $r = \DB::table('settings')->where('name','report')->first();
            return json_decode($r->data);
        });
        $inbox = $report->inbox;
        $users = $report->employee;
        // 立即发送报表
        if($request->scope != ''){
            $date = explode('~',$request->scope);
            $startTime = Carbon::parse($date[0]);
            $endTime = Carbon::parse($date[1])->endOfDay();
            //推送到队列执行，发送报表到邮件
            dispatch(new SendReport($inbox, $users, $startTime, $endTime));
            return back()->with('success', '邮件已经发送至 '.$inbox.' 请留意查收!');
        }else{
            return back()->with('danger', '请选择统计日期时间范围!');
        }
    }

    /**
	 * 上传图片
	 *
	 * @param Request $request
	 * @param ImageUploadHandler $uploader
	 * @return void
	 */
	public function uploadImage(Request $request, ImageUploadHandler $uploader)
	{
		//初始化数据,默认是失败的
		$data = [
			'success' => false,
			'msg' => '上传失败',
			'file_path' => ''
		];
		// 判断是否有文件上传，并赋值给$file
		if($file = $request->upload_file){
			// 保存图片到本地
			$result = $uploader->save($request->upload_file,'records',\Auth::id(),1024);
			//图片保存成功的话
			if($result){
				$data['file_path'] = $result['path'];
				$data['msg'] = '上传成功';
				$data['success'] = true;
			}
		}
		return $data;
    }
    public function receiveEmailCount(Request $request)
    {
        if($request->company != null){
            Log::info("邮件阅读提醒 ".$request->company." 查看了邮件!");
            if(Cache::increment('receiveEmailCount') > 100){
                $count = \DB::table('settings')->where('name','emailCount')->first();
                $emailCount = [
                    'count' => $c->count + Cache::increment('receiveEmailCount'),
                ];
                \DB::table('settings')->where('name','emailCount')->update(["data"=>json_encode($emailCount)]);
                // 清除计数器
                Cache::forget('receiveEmailCount');
            }

        }
        return "ok";
    }
    public function resetEmailCount(Request $request)
    {
            Log::info("清零邮件阅读计数器!");
            $emailCount = [
                'count' => 0,
            ];
            \DB::table('settings')->where('name','emailCount')->update(["data"=>json_encode($emailCount)]);
            // 清除计数器
            Cache::forget('receiveEmailCount');
        return back()->with('success', '邮件已经清零!');
    }
    public function emailClick(Request $request)
    {
            Log::info("客户点击了邮件按钮!");
            if($request->company != null){
                if($request->product){
                    Edm::create(['name' => $request->company,'product' => $request->product]);
                }else if($request->Unsubscribe){
                    Edm::create(['name' => $request->company,'Unsubscribe' => $request->Unsubscribe]);
                }
            }
        return redirect('http://www.kouton.com',301);
    }
    public function edmShow(Request $request,Edm $edm)
    {
        // 邮件阅读
        $emailsCount = \DB::table('settings')->where('name','emailCount')->first();
        $c = json_decode($emailsCount->data);
        $emailCount = [
            'count' => $c->count + Cache::get('receiveEmailCount'),
        ];
        \DB::table('settings')->where('name','emailCount')->update(["data"=>json_encode($emailCount)]);
        // 清除计数器
        Cache::forget('receiveEmailCount');
        $emailsCount = \DB::table('settings')->where('name','emailCount')->first();
        $emailCount = json_decode($emailsCount->data);

        $edms = $edm->orderBy('created_at','desc')->paginate(100);
        return view('emails.show',compact('edms','emailCount'));
    }
    public function edmDelete(Request $request,Edm $edm)
    {
        if($request->ids){
            $data = explode(',',$request->ids);
            foreach ($data as $id) {
                $e = $edm->find($id);
                $e->delete();
            }
        }
        return back()->with('success', '记录已删除!');
    }
}
// http://ktcrm.test/system/emailClick?company=XX公司&product=云会计
// http://ktcrm.test/system/emailClick?company=XX公司&Unsubscribe=退订
// http://ktcrm.test/system/emailClick?company=XX公司&Unsubscribe=投诉