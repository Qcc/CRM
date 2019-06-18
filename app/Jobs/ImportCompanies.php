<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Redis;
use App\Models\Company;
use Illuminate\Support\Facades\Log;

class ImportCompanies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $allHash;
    protected $fileName;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($allHash,$fileName)
    {
        $this->allHash = $allHash;
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $count = 0;
        foreach ($this->allHash as $hash) {
           $company =  Redis::hgetall($hash);
           if($company){
            try {
                $company = Company::updateOrCreate(
                    ['name' =>  $company['name']],
                    ['boss'  => $company['boss'],
                     'money'  => $company['money'],
                     'moneyType'  => $company['moneyType'],
                     'registration'  => $company['registration'],
                     'status'  => $company['status'],
                     'province'  => $company['province'],
                     'city'  => $company['city'],
                     'area'  => $company['area'],
                     'type'  => $company['type'],
                     'phone'  => $company['phone'],
                     'morePhone'  => $company['morePhone'],
                     'address'  => $company['address'],
                     'webAddress'  => $company['webAddress'],
                     'socialCode' => $company['socialCode'],
                     'email'  => $company['email'],
                     'businessScope'  => $company['businessScope']]
                );
                $count++;
            } catch(\Illuminate\Database\QueryException $ex) {
                Log::info('导入公司信息失败 ',$company);
                Log::info('文件名 '.$this->fileName);
                Log::error($ex);
            }
           }else{
            Log::info("未查询到公司信息，导入改行失败". $this->fileName);
            Log::info("hash信息 ".$hash);
           }
            Redis::del($hash);
        }
        Log::info("成功导入了 [". $this->fileName ."] 共计 ".$count." 条公司信息");
    }
}
