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
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class CustomersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**客户成交转为审批正式客户 */
    public function store(CustomerRequest $request, Customer $customer, Company $company, Follow $follow)
    {
        // 缓存老客户维系设置
		$cus = Cache::rememberForever('customer', function (){
            $c = \DB::table('settings')->where('name','customer')->first();
            return json_decode($c->data);
        });
        $customer->fill($request->all());
        $customer->user_id = Auth::id();
        $customer->relationship_at = Carbon::now()->addDay($cus->days);
        $customer->save();
        // 更新客户资料状态为 订单完成
        // $company->where('id',$request->company_id)->update(['follow' => 'complate']);
        // 软删除跟进中的客户
        $follow->whereHas('company',function($query) use ($request){
            $query->where('id', $request->company_id);
        })->delete();
        return redirect()->route('follow.follow')->with('success', '客户资料保存成功');
    }

    // /**
    //  * 上传客户合同
    //  *
    //  * @param Request $request
    //  * @return void
    //  */
    // public function upload(Request $request)
    // {
    //     $data = [
    //         "code" => 1
    //         ,"msg" => "上传失败"
    //         ,"data" => [
    //           "src"=>""
    //         ]
    //     ];

    //     $file = $request->file;
    //     if(!$file -> isValid()){ 
    //         return $data; 
    //     }
    //     // 只允许以下后缀名的图片文件上传
    //     $allowed_ext = ["pdf", "rar"];
    //     // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
    //     $extension = strtolower($file->getClientOriginalExtension()) ?: 'rar';
    //     // 如果上传的不是PDF RAR将终止操作
    //     if ( ! in_array($extension, $allowed_ext)) {
    //         return $data;
    //     }
    //     // 构建存储的文件夹规则，值如：uploads/images/avatars/201709/21/
    //     // 文件夹切割能让查找效率更高。
    //     $filePath ="public/contract/" . date("Ym/d", time()) .'/';
    //     $fileName = 'contract_' . time() . '_' . str_random(10) . '.' . $extension;
    //     $absFile = $filePath.$fileName;
    //     // 将图片移动到我们的目标存储路径中
    //     $boolSave = Storage::putFileAs( $filePath, $file,$fileName);
    //     if($boolSave){
    //       $url = Storage::url($absFile);
    //       $data['code'] = 0;
    //       $data['msg'] = '合同上传成功';
    //       $data['data']['src'] = config('app.url') . $url;
    //       return $data; 
    //     }else{
    //         return $data;
    //     }
    // }

    public function show(Request $request, Customer $customer)
    {
        $user = Auth::user();
        // 检查当前用户是否是管理员
        if($user->can('manager')){
            if($request->name){
                $customers = $customer->withTrashed()->whereHas('company',function($query) use ($request){
                    $query->where('name','like', '%'.$request->name.'%');
                })->with('user')->paginate(10);
            }else{
                $customers = $customer->withTrashed()->with('company')->with('user')->paginate(10);
            }
        }else{
            if($request->name){
                $customers = $customer->where('user_id',$user->id)->whereHas('company',function($query) use ($request){
                    $query->where('name','like', '%'.$request->name.'%');
                })->with('user')->paginate(10);
            }else{
                $customers = $customer->where('user_id',$user->id)->with('company')->with('user')->paginate(10);
            }
        }
        return view('pages.customer.show',compact('customers'));
    }
    
    public function check(Request $request, Customer $customer)
    {
        $this->authorize('manager', $customer);

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

    public function update(Request $request, Customer $customer)
    {        
        $customer = $customer->find($request->id);
        $this->authorize('update', $customer);
        $data = $request->all();
        $data['check'] = 'check';
        $customer->update($data);
        return back()->with('success', '订单资料更新成功!');
    }
    
    public function destroy(Request $request, Customer $customer)
    {
        
        $customer = $customer->find($request->id);
        $this->authorize('destroy', $customer);
        $customer->check = 'delete';
        $customer->save();
        $customer->delete();
        return back()->with('success', '订单已经删除!');
    }
    public function restore(Request $request, Customer $customer)
    {
        $customer = $customer->onlyTrashed()->find($request->id);
        $this->authorize('manager', $customer);
        $customer->restore();
        $customer->check = 'check';
        $customer->save();
        return back()->with('success', '订单已经恢复!');
    }
}
