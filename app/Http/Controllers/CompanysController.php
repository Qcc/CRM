<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use App\Models\Company;
use App\Models\Log as LLog;
use Illuminate\Support\Facades\Log;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;

class CompanysController extends Controller
{
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
            LLog::write($user->name."(".$user->email.")"." 导入了".$count."条公司信息");
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
        $userId = Auth::id();
        foreach ($list as $id) {
            $company->where('id',$id)->update(['follow' => 'locking']);
            Redis::sadd('target_'.$userId,$id);
        }
        $data = [
			'code' => 0,
			'msg' => '选取公司成功',
			'list' => $list
        ];

        return $data;
    }
}
