<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Customer;
use App\Models\Company;
use App\Models\Follow;
use Auth;
use Illuminate\Support\Facades\Log;

class CustomersController extends Controller
{
    /**客户成交转为审批正式客户 */
    public function store(CustomerRequest $request, Customer $customer, Company $company, Follow $follow)
    {
        // dd($request->all());
        $customer->fill($request->all());
        $customer->user_id = Auth::id();
        $customer->save();
        // 更新客户资料状态为 订单完成
        // $company->where('id',$request->company_id)->update(['follow' => 'complate']);
        // 删除跟进中的客户
        $follow->whereHas('company',function($query) use ($request){
            $query->where('id', $request->company_id);
        })->delete();
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
        if($request->name){
            $customers = $customer->whereHas('company',function($query) use ($request){
                $query->where('name','like', '%'.$request->name.'%');
            })->paginate(10);
        }else{
            $customers = $customer->with('company')->paginate(10);
        }
        return view('pages.customer.show',compact('customers'));
    }
    
    public function check(Request $request, Customer $customer)
    {
        $count = 0;
        $ele = explode(',',$request->ids);
        foreach ($ele as $id) {
            if($request->type == 'approve'){
                $res = $customer->where('id',$id)->where('check','check')->update(['check'=>'complate']);
                if($res){
                    $count++;
                }
            }else if($request->type == 'dismissed'){
                $res = $customer->where('id',$id)->where('check','check')->update(['check'=>'dismissed']);
                if($res){
                    $count++;
                }
            }
        }
        return back()->with('success', '成功审核'.$count.'条数据!');
    }

    public function update()
    {
        return back()->with('success', '订单资料更新成功!');
    }
    
    public function destroy()
    {
        return back()->with('success', '订单已经删除!');
    }
}
