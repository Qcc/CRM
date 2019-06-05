<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class SeedSettingsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 业绩等级晋级初始数据
        $level = [
            'level_1' => [
                'performance' => 0,
                'name' => '路人',
                'commission' => 6,
                'call' => 140,
                'effective' => 6, 
            ],
            'level_2' => [
                'performance' => 10000,
                'name' => '师兄',
                'commission' => 7,
                'call' => 130,
                'effective' => 5,
            ],
            'level_3' => [
                'performance' => 30000,
                'name' => '少侠',
                'commission' => 8,
                'call' => 120,
                'effective' => 4,
            ],
            'level_4' => [
                'performance' => 50000,
                'name' => '大侠',
                'commission' => 9,
                'call' => 110,
                'effective' => 3,
            ],
            'level_5' => [
                'performance' => 800000,
                'name' => '掌门',
                'commission' => 10,
                'call' => 100,
                'effective' => 2,
            ],
            'level_6' => [
                'performance' => 150000,
                'name' => '宗师',
                'commission' => 12,
                'call' => 90,
                'effective' => 1,
            ],
        ];
        // 商机管理初始数据
        $business = [
            'days' => 60,
            'delay' => 1,
            'pics' => 2,
            'picOfdays' => 10, 
        ];
        // 老客户维系初始数据
        $customer = [
            'days' => 30,
        ];
        // 报表初始数据
        $report = [
            'start' => Carbon::now()->startOfMonth(),
            'end' => Carbon::now()->endOfMonth(),
            'recently' => Carbon::now()->startOfMonth(),
            'employee' => '', 
            'repeat' => 0,
        ];
        $settings = [
            [
                'name' => 'level',
                'data' => json_encode($level),
            ],
            [
                'name' => 'notice',
                'data' => '大家好！这是一条测试通知。',
            ],
            [
                'name' => 'business',
                'data' => json_encode($business),
            ],
            [
                'name' => 'customer',
                'data' => json_encode($customer),
            ],
            [
                'name' => 'report',
                'data' => json_encode($report),
            ],
        ];
        DB::table('settings')->insert($settings);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('settings')->truncate();
    }
}
