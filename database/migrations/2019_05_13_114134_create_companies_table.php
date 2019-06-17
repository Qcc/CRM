<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->index()->comment('公司名称');
            $table->string('boss')->comment('法定代表人');
            $table->integer('money')->nullable()->comment('注册资本');
            $table->string('moneyType')->nullable()->comment('资本类型');
            $table->date('registration')->comment('成立日期');
            $table->string('status')->comment('经营状态');
            $table->string('province')->comment('所属省份');
            $table->string('city')->nullable()->comment('所属市区');
            $table->string('area')->nullable()->comment('所属区县');
            $table->string('type')->nullable()->comment('公司类型');
            $table->string('socialCode')->unique()->comment('统一社会信用代码');
            $table->string('phone')->nullable()->comment('企业公示的联系电话');
            $table->string('morePhone')->nullable()->comment('企业公示的联系电话（更多号码）');
            $table->string('address')->nullable()->comment('企业公示的地址');
            $table->string('webAddress')->nullable()->comment('企业公示的网址');
            $table->string('email')->nullable()->comment('企业公示的邮箱');
            $table->string('businessScope')->nullable()->comment('经营范围');
            // '0' 目标客户, '1' 锁定中待跟进 '2' 跟进中, '3'成交客户
            $table->integer('follow')->default(0)->comment('跟进状态');
            $table->boolean('contacted')->default(false)->comment('跟进过');
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
        Schema::dropIfExists('companies');
    }
}
