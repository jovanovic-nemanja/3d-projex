<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderlist', function (Blueprint $table) {
            $table->increments('id');

            $table->text('order_number');
            $table->text('checking_num');
            $table->text('model_name');
            $table->integer('model_price');
            $table->text('model_photo');
            $table->integer('order_count');
            $table->integer('userid');
            $table->datetime('order_date');

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
        Schema::dropIfExists('orderlist');
    }
}
