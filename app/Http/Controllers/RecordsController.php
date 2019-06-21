<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Record;
use App\Models\Follow;
use Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RecordsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
	 * 陌生客户提交首次反馈 保存提交的反馈
	 *
	 * @param Request $request
	 * @return void
	 */
	public function Store(Request $request, Record $record, Company $company, Follow $follow)
	{

        // 将目标公司的状态修改为跟进中 follow
            // $company->where('id',$request->company->id)->update(['follow' => 'follow']);
            // 修改状态后将公司从目标客户中删除，转为跟进客户
            // Redis::srem('target_'.$user->id,$request->company->id);
            // 将目标公司id 放入跟进客户 集合中
            // Redis::sadd('follow_'.$user->id,$id);

        $user = Auth::user();
        // 判断 $request->company->id 元素是否是集合 'target_'.$user->id 的成员
        if(Redis::sismember('target_'.$user->id,$request->company_id)){
            if($request->feed == 1 && strlen($request->content) < 38){
                return back()->withInput()->with('danger', '反馈结果不能少于10个字。');
            }
            $feed='';
            switch($request->feed){
                case 1: $feed = '<p>电话号码正确，可以继续跟进。</p>';
                break;
                case 2: $feed = '<p>电话号码正确，暂时没有需要。</p>';
                break;
                case 3: $feed = '<p>电话号码不正确，不是本人。</p>';
                break;
                case 4: $feed = '<p>空号，挂断，无人接，无法联系。</p>';
                break;
            }
            $author = "<p class='pr'>跟进人:".$user->name."</p>";
            $record->content = $request->content.$feed.$author;
            $record->user_id = $user->id;
            $record->company_id = $request->company_id;
            $record->feed = $request->feed;
            $record->familiar = true;
            $record->save();
            if($request->feed == 1){
                // 缓存商机管理设置
		        $business = Cache::rememberForever('business', function (){
                    $b = \DB::table('settings')->where('name','business')->first();
                    return json_decode($b->data);
                });
                // 将有效商机转化为 持续跟进的客户 商机默认保留 60天 过期将重新放入公海
                $follow->countdown_at = Carbon::parse('+'.$business->days.' days');
                $follow->user_id = $user->id;
                // 延期次数
                $follow->delayCount = $business->pics;
                $follow->company_id = $request->company_id;
                $follow->save();
                // 将目标公司的状态修改为跟进中 跟进中 增加跟进记录
                $company->where('id',$request->company_id)->update(['follow' => 2,'contacted'=>true]);
            }else{
                // 将目标公司的状态修改为可跟进 目标客户 增加跟进记录
                $company->where('id',$request->company_id)->update(['follow' => 0,'contacted'=>true]);
            }
            // 修改状态后将公司从目标客户中删除
            Redis::srem('target_'.$user->id,$request->company_id);
            // 返回目标客户集合 'target_'.$user->id 中的所有成员
            $follows = Redis::smembers('target_'.$user->id);
            $companys = $company->find($follows);
            if($request->next == -1){
                return redirect(route('company.follow'))->with('success', '反馈成功，目标客户已经全部联系完!');
            }else{
                return redirect(route('company.show',$request->next))->with('success', '反馈成功,继续联系更多客户!');
            }
        }else{
            return abort(404);
        }

	}
}
