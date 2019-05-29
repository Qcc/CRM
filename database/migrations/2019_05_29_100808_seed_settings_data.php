<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
                'commission' => 6
            ],
            'level_2' => [
                'performance' => 10000,
                'name' => '师兄',
                'commission' => 7,
            ],
            'level_3' => [
                'performance' => 30000,
                'name' => '少侠',
                'commission' => 8,
            ],
            'level_4' => [
                'performance' => 50000,
                'name' => '大侠',
                'commission' => 9,
            ],
            'level_5' => [
                'performance' => 800000,
                'name' => '掌门',
                'commission' => 10,
            ],
            'level_6' => [
                'performance' => 150000,
                'name' => '宗师',
                'commission' => 12,
            ],
        ];
        // 商机管理初始数据
        $business = [
            'days' => 60,
            'delay' => 1,
            'pics' => 2,
            'picOfdays' => 10, 
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
