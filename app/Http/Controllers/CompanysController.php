<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use App\Models\Company;
use App\Models\Follow;
use App\Models\Customer;
use App\Models\Record;
use App\Models\Speech;
use Illuminate\Support\Facades\Log;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

class CompanysController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * 搜索公海目标客户
     *
     * @return void
     */
    public function secrch(Request $request,Company $company)
    {
        // 关键字查询
        $companys = Company::when($request->key, function ($query) use ($request) {
            return $query->where('name','like', '%'.$request->key.'%')
                         ->orwhere('businessScope','like', '%'.$request->key.'%');
            })
            // 所属行业
            ->when($request->businessScope, function ($query) use ($request) {
                $businessScope = explode("-",$request->businessScope);
                return $query->when($businessScope[0], function ($query) use ($businessScope) {
                        return $query->orwhere('businessScope','like', '%'.$businessScope[0].'%');
                    })->when(isset($businessScope[1]), function ($query) use ($businessScope) {
                        return $query->orwhere('businessScope','like', '%'.$businessScope[1].'%');
                    })->when(isset($businessScope[2]), function ($query) use ($businessScope) {
                        return $query->orwhere('businessScope','like', '%'.$businessScope[2].'%');
                    })->when(isset($businessScope[3]), function ($query) use ($businessScope) {
                        return $query->orwhere('businessScope','like', '%'.$businessScope[3].'%');
                    })->when(isset($businessScope[4]), function ($query) use ($businessScope) {
                        return $query->orwhere('businessScope','like', '%'.$businessScope[4].'%');
                    });
            })
            // 注册资金查询
            ->when($request->money, function ($query) use ($request) {
                $money = explode("-",$request->money);
                return $query->whereBetween('money',[$money[0], $money[1]]);
            })
            // 跟进记录
            ->when($request->contacted, function ($query) use ($request) {
                return $query->where('contacted',$request->contacted == "on" ? true:false);
            })
            // 所属城市
            ->when($request->city, function ($query) use ($request) {
                return $query->where('city',$request->city);
            })
            // 成立日期查询
            ->when($request->registration, function ($query) use ($request) {
                $registration = explode("-",$request->registration);
                $year1 = Carbon::parse("-".($registration[0]*365)." days")->toDateString();
                $year2 = Carbon::parse("-".($registration[1]*365)." days")->toDateString();
                return $query->whereBetween('registration',[$year2, $year1]);
            })->select(['id','name','boss','money','moneyType','registration','status','province','city','area','type','socialCode',
            'address','webAddress','businessScope','follow','contacted',
            ])->paginate(100);
            // 关键字查询
            $cookie = Cookie::make('querys_for_js', json_encode($request->all()), 1, $path = '/', $domain = null, $secure = false, $httpOnly = false);
        return response()->view('pages.company.secrch',compact('companys'))->cookie($cookie);
    }
    /**
     * 显示批量上传客户资料
     *
     * @return void
     */
    public function upload()
    {
        return view('pages.company.upload');
    }
    /**
     * 批量上传客户资料保存
     *
     * @return void
     */
    public function store(Request $request,Company $company)
    {
        //初始化数据,默认是失败的
		$data = [
			'code' => 1,
			'msg' => '上传失败'
        ];
        // 判断是否有文件上传，并赋值给$file
		if($file = $request->file){
            ini_set('memory_limit', -1);
            set_time_limit(0);
            $reader = ReaderFactory::create(Type::XLSX);
            $reader->setShouldFormatDates(true);
            $reader->open($file);
            $count = 0;
            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $index => $row) {
                    if($row[0] == '' && $row[9]==''){
                        break;
                    }
                    if($index != 1){
                        $money = explode('万',$row[2]);
                        try {
                            $company = Company::updateOrCreate(
                                ['name' => $row[0], 'socialCode' => $row[9]],
                                ['boss' =>$row[1],
                                 'money' =>is_numeric($money[0])?$money[0]:0,
                                 'moneyType' =>$money[1]??'人民币',
                                 'registration' =>$row[3],
                                 'status' =>$row[4],
                                 'province' =>$row[5],
                                 'city' =>$row[6],
                                 'area' =>$row[7],
                                 'type' =>$row[8],
                                 'phone' =>$row[10],
                                 'morePhone' =>$row[11],
                                 'address' =>$row[12],
                                 'webAddress' =>$row[13],
                                 'email' =>$row[14],
                                 'businessScope' =>$row[15],]
                            );
                            $count++;
                        } catch(\Illuminate\Database\QueryException $ex) {
                            Log::error($ex);
                        }
                    }
                }
            }
            $data = [
                'code' => 0,
                'msg' => '上传成功'
            ];
            $user = Auth::user();
            Log::info($user->name."(".$user->email.")"." 导入了".$count."条公司信息");
        }
        return $data;
    }

    // 选取公司并当天锁定，其他职员不允许选取。
    public function locking(Request $request,Company $company)
    {
        //初始化数据,默认是失败的
		$data = [
			'code' => 1,
			'msg' => '选取公司失败'
        ];
        $list = json_decode($request->list,true);
        $user = Auth::user();
        // 选取计数
        $count = 0;
        // 最大跟进客户数量
        $max = '';
        foreach ($list as $id) {
            // 获取已经作为目标客户的公司数量
            $already = Redis::scard('target_'.$user->id);
            if($already >= 100){
                $max = ',同时跟进的目标客户不能超过100家。';
                break;
            }
            $result = $company->where('id',$id)->where('follow','target')->update(['follow' => 'locking']);
            if($result){
                // 将目标公司id 放入目标客户 集合中
                Redis::sadd('target_'.$user->id,$id);
                $count++;
            }
        }
        Log::info($user->name."(".$user->email.")"." 成功选取了".count($list)." 家公司，准备跟进");
        $data = [
			'code' => 0,
			'msg' => '成功选取了'.$count.'家客户'.$max,
			'list' => $list
        ];

        return $data;
    }

    // 跟进陌生目标客户列表
    public function follow(Company $company, Follow $follow, Customer $customer, Record $record)
    {
        $user = Auth::user();
        // 返回集合 'target_'.$user->id 中的所有成员
        $follows = Redis::smembers('target_'.$user->id);
        $companys = $company->find($follows);
        $recordsOfMonth = $record->where('user_id',$user->id)->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->get();
            // 本月拨打电话
        $callCountOfMonth = 0;
        // 本月有效商机
        $businessCountOfMonth = 0;
        foreach ($recordsOfMonth as $r) {
            if($r->familiar == true){
                $callCountOfMonth++;
            }
            if($r->feed == 'lucky'){
                $businessCountOfMonth++;
            }
        }
        $customersOfMonth = $customer->where('user_id',$user->id)->where('check','complate')
        ->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->get();
        // 本月成交客户
        $cusCountOfMonth = 0;
        $moneyOfMonth = 0;
        // 本月成交金额
        foreach ($customersOfMonth as $c) {
            $cusCountOfMonth++;
            $moneyOfMonth += $c->contract_money;
        }
        // 当天
        $recordsOfDay = $record->where('user_id',$user->id)
            ->whereBetween('created_at',[Carbon::now()->startOfDay(),Carbon::now()->endOfDay()])->get();
        // 当天拨打电话
        $callCountOfDay = 0;
        // 当天有效商机
        $businessCountOfDay = 0;
        foreach ($recordsOfDay as $r) {
            if($r->familiar == true){
                $callCountOfDay++;
            }
            if($r->feed == 'lucky'){
                $businessCountOfDay++;
            }
        }
        $customersOfDay = $customer->where('user_id',$user->id)
        ->whereBetween('created_at',[Carbon::now()->startOfDay(),Carbon::now()->endOfDay()])->get();
        // 当天成交客户
        $cusCountOfDay = 0;
        $moneyOfDay = 0;
        // 当天成交金额
        foreach ($customersOfDay as $c) {
            $cusCountOfDay++;
            $moneyOfDay += $c->contract_money;
        }
        // 上个月客户
        $customersOfLastMonth = $customer->where('user_id',$user->id)
        ->whereBetween('created_at',[Carbon::now()->startOfMonth()->subMonths(1),Carbon::now()->startOfMonth()->subMonths(1)->endOfMonth()])->get();
        // 上个月成交金额
        $moneyOfLastMonth = 0;
        foreach ($customersOfLastMonth as $c) {
            $moneyOfLastMonth += $c->contract_money;
        }
        // 本月等级由上个月决定
        $thisMonth = howLevel($moneyOfLastMonth);
        // 缓存通知设置
		$notice = Cache::rememberForever('notice', function (){
            $n = \DB::table('settings')->where('name','notice')->first();
            return $n->data;
        });
        // 本月 当天 业绩统计
        $achievement = [
            'callCountOfMonth' => $callCountOfMonth,
            'businessCountOfMonth' => $businessCountOfMonth,
            'cusCountOfMonth' => $cusCountOfMonth,
            'moneyOfMonth' => $moneyOfMonth,
            'callCountOfDay' => $callCountOfDay,
            'businessCountOfDay' => $businessCountOfDay,
            'cusCountOfDay' => $cusCountOfDay,
            'moneyOfDay' => $moneyOfDay,
            'notice' => $notice,
            'level' => $thisMonth,
        ];
        return view('pages.company.follow',compact('companys','achievement'));
    }
    // 跟进陌生目标客户
    public function show(Request $request, Company $company, Speech $speech)
    {
        $user = Auth::user();
        $speechs = 
        // 缓存话术
		$speechs = Cache::rememberForever('speechs', function () use($speech){
            return $speech->whereNotNull("answer")->orderBy('updated_at','desc')->get();
        });
        // 判断 $request->company->id 元素是否是集合 'target_'.$user->id 的成员
        if(Redis::sismember('target_'.$user->id,$request->company->id)){
            // 将目标公司的状态修改为跟进中 follow
            // $company->where('id',$request->company->id)->update(['follow' => 'follow']);
            // 修改状态后将公司从目标客户中删除，转为跟进客户
            // Redis::srem('target_'.$user->id,$request->company->id);
            // 将目标公司id 放入跟进客户 集合中
            // Redis::sadd('follow_'.$user->id,$id);

            // 返回集合 'target_'.$user->id 中的所有成员
            $follows = Redis::smembers('target_'.$user->id);
            $companys = $company->find($follows);
            return view('pages.company.show',compact('companys','company', 'speechs'));
        }else{
            return abort(404);
        }
    }
}
