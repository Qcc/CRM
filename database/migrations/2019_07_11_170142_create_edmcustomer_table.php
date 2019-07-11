<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdmcustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edmcustomer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('公司名称');
            $table->string('product')->nullable()->comment('意向产品');
            $table->string('Unsubscribe')->nullable()->comment('退订投诉');
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
        Schema::dropIfExists('edmcustomer');
    }
}
