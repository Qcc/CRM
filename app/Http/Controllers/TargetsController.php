<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use App\Models\Target;
use App\Models\Log as LLog;
use Illuminate\Support\Facades\Log;
use Auth;
class TargetsController extends Controller
{
    /**
     * 搜索公海目标客户
     *
     * @return void
     */
    public function secrch()
    {
        return view('pages.target');
    }
    /**
     * 显示批量上传客户资料
     *
     * @return void
     */
    public function show()
    {
        return view('pages.create');
    }
    /**
     * 批量上传客户资料保存
     *
     * @return void
     */
    public function store(Request $request,Target $target)
    {
        //初始化数据,默认是失败的
		$data = [
			'code' => 1,
			'msg' => '上传失败'
        ];
        // 判断是否有文件上传，并赋值给$file
		if($file = $request->file){
            ini_set('memory_limit', -1);
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
                        Log::info($row);
                        $money = explode('万',$row[2]);
                        Log::info($money);
                        try {
                            $target = Target::updateOrCreate(
                                ['company' => $row[0], 'socialCode' => $row[9]],
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
            $user = Auth::user();
            LLog::write($user->name."(".$user->email.")"." 导入了".$count."条公司信息");
        }
        return $data;
    }
}
