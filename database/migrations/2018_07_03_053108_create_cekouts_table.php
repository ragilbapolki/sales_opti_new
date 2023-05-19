<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCekoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cekouts', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tgl')->nullable()->comment('Null = blm cekout');
            $table->integer('user_id')->unsigned();
            $table->string('customer_id','33');
            $table->integer('plan_id')->unsigned()->unique();
            $table->integer('cekin_id')->unsigned()->unique();
            $table->string('keterangan')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->tinyInteger('lost_from_cekin')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('cekin_id')->references('id')->on('cekins')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cekouts');
    }
}
