<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Customer;
use App\Models\Company;
use App\Models\Follow;
use App\Models\Record;
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
    public function store(CustomerRequest $request, Customer $customer, Company $company, Follow $follow, Record $record)
    {
        $user = Auth::user();
        // 缓存老客户维系设置
		$cus = Cache::rememberForever('customer', function (){
            $c = \DB::table('settings')->where('name','customer')->first();
            return json_decode($c->data);
        });
        if($request->customer_id){
            $customer = $customer->withTrashed()->find($request->customer_id);
            $content = "<h3>过期订单转结</h3>"
            ."<table>
                <thead>
                    <tr>
                        <th>联系人</th>
                        <th>电话</th>
                        <th>成交产品</th>
                        <th>订单金额</th>
                        <th>成交日期</th>
                        <th>售后到期</th>
                        <th>合同</th>
                        <th>订单备注</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>".$customer->contact."</td>
                        <td>".$customer->phone."</td>
                        <td>".$customer->product."</td>
                        <td>￥".$customer->contract_money."</td>
                        <td>".$customer->completion_at->toDateString()."</td>
                        <td>".$customer->expired_at->toDateString()."</td>
                        <td><a class='color-blue' href=".$customer->contract.">".substr(strrchr($customer->contract,'/'),1)."</a></td>
                        <td>".$customer->comment."</td>
                    </tr>
                </tbody>
            </table>";
            // 将之前订单保存到跟进记录中，
            $author = "<p class='pr'>跟进人:".$user->name."</p>";
            $record->content = $content.$author;
            $record->user_id = $user->id;
            $record->company_id = $request->company_id;
            $record->save();

            // 覆盖新的订单信息
            $customer->fill($request->all());
            $customer->user_id = $user->id;
            $customer->check = 'check';
            $customer->relationship_at = Carbon::now()->addDay($cus->days);
            $customer->save();
        }else{
            $customer->fill($request->all());
            $customer->user_id = Auth::id();
            $customer->relationship_at = Carbon::now()->addDay($cus->days);
            $customer->save();
        }
        // 更新客户资料状态为 订单完成
        // $company->where('id',$request->company_id)->update(['follow' => 'complate']);
        // 软删除跟进中的客户
        $follow->find($request->follow_id)->delete();
        return redirect()->route('customer.show',$customer->id)->with('success', '订单已经生成，审核中...');
    }

    public function index(Request $request, Customer $customer)
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
        return view('pages.customer.index',compact('customers'));
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
    
    public function show(Request $request, Customer $customer)
    {
        return view('pages.customer.show',compact('customer'));
    }
    // 维系老客户保持联系
    public function keep(Request $request)
    {
        if(strlen($request->content) < 38){
            return back()->withInput()->with('danger', '反馈结果不能少于10个字。');
        }
        // 缓存老客户维系设置
		$cus = Cache::rememberForever('customer', function (){
            $c = \DB::table('settings')->where('name','customer')->first();
            return json_decode($c->data);
        });
        $customer = Customer::find($request->customer_id);
        $customer->update(['relationship_at'=>Carbon::now()->addDay($cus->days)]);
        
        $record = new Record;
        $user = Auth::user();
        $author = "<p class='pr'>跟进人:".$user->name."</p>";
        $record->content = $request->content.$author;
        $record->user_id = Auth::id();
        $record->company_id = $request->company_id;
        $record->save();
        return back()->with('success', '联系结果已经反馈!');
    }
}
