<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->default(0)->index();
            $table->integer('company_id')->unsigned()->unique()->index();
            $table->integer('customer_id')->unsigned()->nullable()->index();
            $table->string('contact')->nullable()->comment('关键联系人');
            $table->string('phone')->nullable()->comment('电话');
            $table->string('product')->nullable()->comment('意向产品');
            $table->text('difficulties')->nullable()->comment('公关难点');
            $table->date('expected_at')->nullable()->comment('预计成交时间');
            $table->dateTime('schedule_at')->nullable()->comment('下次联系提醒');
            $table->dateTime('countdown_at')->comment('跟进截至日期');
            $table->integer('delayCount')->comment('延期次数');
            $table->float('contract_money')->nullable()->comment('预计成交金额');
            // 软删除
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follows');
    }
}
