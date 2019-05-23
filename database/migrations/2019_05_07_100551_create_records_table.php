<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->default(0)->index();
            $table->integer('user_id')->unsigned()->default(0)->index();
            $table->text('content');
            $table->boolean('familiar')->default(false)->comment('是否首次联系');
            // 跟进状态 'follow',有效商机客户普通跟进 'lucky',首次跟进有效 'wrongnumber',电话号码不正确 'noneed'电话号码正确没有需要
            $table->enum('feed', ['follow', 'lucky', 'wrongnumber', 'noneed','email'])->default('follow')->comment('跟进状态');
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
        Schema::dropIfExists('records');
    }
}
