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
            $table->string('id',33);
            $table->string('kode_cabang')->nullable();
            $table->string('update_cabang')->nullable();
            // $table->string('ccc',33)->unique()->nullable();
            $table->string('ccc',33)->nullable();
            $table->string('ccc_reg')->nullable();
            $table->string('ccc_level')->nullable();
            $table->string('name','255');
            $table->string('titel')->nullable();
            $table->string('tgl_lahir')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kota')->nullable();
            $table->string('telp')->nullable();
            $table->string('npwp')->nullable();
            $table->dateTime('last_visited')->nullable();
            $table->dateTime('last_transaksi')->nullable();
            $table->timestamps();
            $table->primary('id');
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
