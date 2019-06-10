<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
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
    protected $scope;

    /**
     * 初始化发送参数
     *
     * @param [type] $emials 接收报表邮箱地址，多个邮箱‘,’号隔开
     * @param [type] $users 需要统计的用户ID，多个ID‘,’号隔开
     * @param [type] $scope 统计时间段
     */
    public function __construct($emials,$users,$scope)
    {
        $this->emials = $emials;
        $this->users = $users;
        $this->scope = $scope;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $date = explode('~',$this->scope);
        $start = Carbon::parse($date[0]);
        $end = Carbon::parse($date[1])->endOfDay();
        $users = explode(',',$this->users);
        // 统计数据
        $statistics = [];
        // 明细数据
        $details = [];
        foreach ($users as $index => $user) {
            $user = User::find($user);
            // 客户
            $customers = Customer::where('user_id',$user->id)->with(['company:id,name'])->where('check','complate')
            ->whereBetween('created_at',[$start,$end])->get();
            // 成交客户
            $cusCount = 0;
            $money = 0;
            // 成交金额
            foreach ($customers as $c) {
                $cusCount++;
                $money += $c->contract_money;
            }

            // 跟进中的客户
            $follows = Follow::where('user_id',$user->id)->with(['company:id,name'])->get();

            // 拨打电话统计
            $records = Record::where('user_id',$user->id)->with(['company:id,name'])->whereBetween('created_at',[$start,$end])->get();
            // 拨打电话
            $callCount = 0;
            // 有效商机
            $businessCount = 0;
            foreach ($records as $r) {
                if($r->familiar == true){
                    $callCount++;
                }
                if($r->feed == 'lucky'){
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
            $line = (object)[];
            $line->id = $index + 1;
            $line->name = $user->name;
            $line->callCount = $callCount;
            $line->businessCount = $businessCount;
            $line->busEfficiency = $callCount == 0 ? 0: round($businessCount / $callCount,3)*100;
            $line->cusCount = $cusCount;
            $line->cusEfficiency = $callCount == 0 ? 0:round($cusCount / $businessCount,3)*100;            
            $line->money = $money;
            array_push($statistics, $line);
        }
        $total = (object)[];
        $total->name = "合计";
        $total->total = 0;
        foreach ($statistics as $ele) {
            $total->total += $ele->money;
        }       
        array_push($statistics, $total);
        // 根据业绩排序
        // usort($statistics, function($a, $b){
        //     return $a->money > $b->money;
        // });
        return view('emails.report',compact('scope', 'statistics','details'));
    }
}
