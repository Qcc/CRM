<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Customer;
use Auth;

class CustomersController extends Controller
{
    /**客户成交转为正式客户 */
    public function store(CustomerRequest $request, Customer $customer)
    {
        // dd($request->all());
        $customer->fill($request->all());
        $customer->user_id = Auth::id();
        $customer->save();
        return redirect()->route('follow.follow')->with('success', '客户资料保存成功');
    }

    /**
     * 上传客户合同
     *
     * @param Request $request
     * @return void
     */
    public function upload(Request $request)
    {
        $data = [
            "code" => 1
            ,"msg" => "上传失败"
            ,"data" => [
              "src"=>""
            ]
        ];

        $file = $request->file;
        if(!$file -> isValid()){ 
            return $data; 
        }
        // 只允许以下后缀名的图片文件上传
        $allowed_ext = ["pdf", "rar"];
        // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'rar';
        // 如果上传的不是PDF RAR将终止操作
        if ( ! in_array($extension, $allowed_ext)) {
            return $data;
        }
        // 构建存储的文件夹规则，值如：uploads/images/avatars/201709/21/
        // 文件夹切割能让查找效率更高。
        $filePath ="public/contract/" . date("Ym/d", time()) .'/';
        $fileName = 'contract_' . time() . '_' . str_random(10) . '.' . $extension;
        $absFile = $filePath.$fileName;
        // 将图片移动到我们的目标存储路径中
        $boolSave = Storage::putFileAs( $filePath, $file,$fileName);
        if($boolSave){
          $url = Storage::url($absFile);
          $data['code'] = 0;
          $data['msg'] = '合同上传成功';
          $data['data']['src'] = config('app.url') . $url;
          return $data; 
        }else{
            return $data;
        }
    }

    public function show(Request $request, Customer $customer)
    {
        $customers = $customer->with('company')->paginate(10);
        return view('pages.customer.show',compact('customers'));
    }
}
