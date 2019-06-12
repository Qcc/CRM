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

class SendReportOfMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendReport:month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每月1号早上8点发送前一月的报表';

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
        Log::info('获取配置信息，准备发送月报表');
        if($report->repeat->month == 1){
            $startTime = Carbon::now()->subMonth()->firstOfMonth()->startOfDay();
            $endTime = Carbon::now()->subMonth()->lastOfMonth()->endOfDay();
            //推送到队列执行，发送报表到邮件
            dispatch(new SendReport($report->inbox, $report->employee, $startTime, $endTime,'商机月报'));
            Log::info('推送到队列准备发送月报表');
        }else{
            Log::info('月报表未发送');
        }
    }
}
