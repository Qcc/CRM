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
            $table->integer('company_id')->unsigned()->default(0)->index();
            $table->string('contact')->comment('关键联系人');
            $table->string('phone')->comment('电话');
            $table->string('qq')->comment('QQ');
            $table->string('email')->comment('邮箱');
            $table->string('product')->comment('意向产品');
            $table->text('difficulties')->comment('公关难点');
            $table->date('expired')->comment('预计成交时间');
            $table->integer('money')->comment('预计成交金额');
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
