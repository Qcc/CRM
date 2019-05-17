<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Record;
use App\Models\Follow;
use Auth;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

class RecordsController extends Controller
{
    /**
	 * 保存提交的反馈
	 *
	 * @param Request $request
	 * @return void
	 */
	public function store(Request $request, Company $company, Record $record, Follow $follow)
	{
        // dd($request->all());
        $user = Auth::user();
        if(Redis::sismember('target_'.$user->id,$request->company_id)){
            if($request->feed == 'lucky' && strlen($request->content) < 38){
                return back()->withInput()->with('danger', '反馈结果不能少于10个字。');
            }
            $feed='';
            $email='';
            switch($request->feed){
                case 'lucky': $feed = '<p>电话号码正确，可以继续跟进。</p>';
                break;
                case 'noneed': $feed = '<p>电话号码正确，暂时没有需要。</p>';
                break;
                case 'wrongnumber': $feed = '<p>电话号码不正确，无法联系。</p>';
                break;
            }
            if($request->email){
                $email = "<p>发送了邮件，内容是</p>";
            }
            $author = "<p class='pr'>跟进人:".$user->name."</p>";
            $record->content = $request->content.$email.$feed.$author;
            $record->user_id = Auth::id();
            $record->company_id = $request->company_id;
            $record->feed = $request->feed;
            $record->save();
            if($request->feed == 'lucky'){
                // 将有效商机转化为 持续跟进的客户
                $follow->countdown = Carbon::parse('+60 days');
                $follow->user_id = Auth::id();
                $follow->company_id = $request->company_id;
                $follow->save();
            }
            $follows = Redis::smembers('target_'.$user->id);
            $companys = $company->find($follows);
            if($request->next == -1){
                return view('pages.company.follow',compact('companys'));
            }else{
                return redirect(route('company.show',$request->next));
            }
        }else{
            return abort(404);
        }

	}
}
