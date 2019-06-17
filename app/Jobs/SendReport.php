<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\Follow;
use App\Models\Customer;
use App\Models\Record;
use App\Models\User;

class SendReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emials;
    protected $users;
    protected $startTime;
    protected $endTime;
    protected $title;

    /**
     * 初始化发送参数
     *
     * @param [type] $emials 接收报表邮箱地址，多个邮箱‘,’号隔开
     * @param [type] $users 需要统计的用户ID，多个ID‘,’号隔开
     * @param [type] $startTime 统计起始时间
     * @param [type] $endTime 统计结束时间
     * @param [type] $title 报表标题
     */
    public function __construct($emials,$users,$startTime, $endTime, $title = '沟通科技CRM商机统计报表')
    {
        $this->emials = $emials;
        $this->users = $users;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->title = $title;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = explode(',',$this->users);
        // 统计数据
        $statistics = [];
        // 明细数据
        $details = [];
        foreach ($users as $index => $user) {
            $user = User::find($user);
            if($user){
                // 客户
                $customers = Customer::where('user_id',$user->id)->with(['company:id,name'])->where('check',3)
                ->whereBetween('created_at',[$this->startTime,$this->endTime])->get();
                // 成交客户
                $cusCount = 0;
                // 收入
                $revenue = 0;
                // 成交金额
                foreach ($customers as $c) {
                    $cusCount++;
                    $revenue += $c->contract_money;
                }
                
                // 跟进中的客户
                $follows = Follow::where('user_id',$user->id)->with(['company:id,name'])->get();
                
                // 拨打电话统计
                $records = Record::where('user_id',$user->id)->with(['company:id,name'])->whereBetween('created_at',[$this->startTime,$this->endTime])->get();
                // 拨打电话
                $callCount = 0;
                // 有效商机
                $businessCount = 0;
                foreach ($records as $r) {
                    if($r->familiar == true){
                        $callCount++;
                    }
                    if($r->feed == 1){
                        $businessCount++;
                    }
                }
                // 详细信息
                $employee = (object)[];
                $employee->user = $user;
                $employee->customers = $customers;
                $employee->follows = $follows;
                $employee->records = $records;
                array_push($details,$employee);
            
                // 统计数据
                // $line = (object)[];
                $line = json_decode('{}');
                $line->name = $user->name;
                $line->callCount = $callCount;
                $line->businessCount = $businessCount;
                $line->busEfficiency = $callCount == 0 ? 0: round($businessCount / $callCount,3)*100;
                $line->cusCount = $cusCount;
                $line->cusEfficiency = $callCount == 0 ? 0:round($cusCount / $businessCount,3)*100;            
                $line->revenue = $revenue;
                array_push($statistics, $line);
            }
        }
        // 根据业绩排序
        usort($statistics, function($a, $b){
            return $a->revenue < $b->revenue;
        });
        // 添加行末合计
        $total = json_decode('{}');
        $total->name = "合计";
        $total->total = 0;   
        foreach ($statistics as $ele) {
            $total->total += $ele->revenue;
        }    
        array_push($statistics, $total);
        $inboxs = explode(';',$this->emials);
        foreach ($inboxs as $inbox) {        
            Log::info('发送报表邮件到'.$inbox);    
            //发邮件
            Mail::send('emails.report',[
                'scope'=>$this->startTime."~".$this->endTime, 
                'statistics'=>$statistics,
                'details'=>$details
            ],function($message) use($inbox)
            {
                $message ->to($inbox)->subject($this->title.$this->startTime."~".$this->endTime);
            });
        }
    }
}
