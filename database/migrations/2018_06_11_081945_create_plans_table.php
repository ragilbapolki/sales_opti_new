<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('kode_cabang','11');
            $table->string('title');
            $table->date('tgl');
            $table->string('customer_id','33');
            $table->string('keterangan');
            $table->string('ket_tolak')->nullable();
            // $table->integer('approve')->default(0);
            // $table->integer('cek_in')->default(0);
            // $table->integer('cek_out')->default(0);
            $table->integer('status')->default(0)->comment('0=pending,1=approve,2=cekin,3=selesai,4=tolak,5=cekin tanpa approve,6=selesai tanpa approve');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
