<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
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
        //
    }
}
