<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class EmptyTarget extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Empty:Target';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清空当日选定的跟进目标客户';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(User $user,Company $company)
    {
        Log::info("开始清空当前未未联系的目标客户名单");
        $users = $user->get();
        foreach ($users as  $u) {
            Log::info('清空 '.$u->name.' 未联系的目标客户名单');
            $el = Redis::smembers("target_".$u->id);
            if(count($el)){
                // 清空选定跟进目标
                Redis::srem("target_".$u->id,$el);
                // 将已选定未跟进的目标解除锁定状态 重新更新为 target 可跟进状态
                $company->whereIn('id',$el)->update(['follow'=>0]);
            }
        }
        Log::info("清空当前未未联系的目标客户名单完成");
    }
}
