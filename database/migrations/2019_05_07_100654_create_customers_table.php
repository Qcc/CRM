<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->default(0)->index();
            $table->integer('company_id');
            // 'status' 签订合同状态, 'check' 审核中 'dismissed' 跟进中, 'complate'成交客户
            $table->enum('check', ['check', 'dismissed', 'complate'])->default('Check')->comment('审核状态');
            $table->string('contact')->comment('关键联系人');
            $table->string('phone')->comment('电话');
            $table->string('product')->comment('成交产品');
            $table->string('contract')->comment('合同');
            $table->date('completion_date')->comment('成交日期');
            $table->date('expired')->comment('售后到期');
            $table->float('contract_money')->comment('成交金额');
            $table->text('comment')->nullable()->comment('项目备注信息');
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
        Schema::dropIfExists('customers');
    }
}
