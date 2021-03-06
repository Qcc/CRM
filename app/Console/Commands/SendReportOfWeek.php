<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Jobs\SendReport;
use Illuminate\Support\Facades\Log;

class SendReportOfWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendReport:week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每周一早上8点发送前一周的报表';

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
        // 缓存报表设置
		$report = Cache::rememberForever('report', function (){
            $r = \DB::table('settings')->where('name','report')->first();
            return json_decode($r->data);
        });
        Log::info('获取配置信息，准备发送周报表');
        if($report->repeat->week == 1){
            $startTime = Carbon::now()->subWeek()->startOfWeek();
            $endTime = Carbon::now()->subWeek()->endOfWeek();
            //推送到队列执行，发送报表到邮件
            dispatch(new SendReport($report->inbox, $report->employee, $startTime, $endTime,'商机周报'));
            Log::info('推送到队列准备发送周报表');
        }else{
            Log::info('周报表未发送');
        }
    }
}
