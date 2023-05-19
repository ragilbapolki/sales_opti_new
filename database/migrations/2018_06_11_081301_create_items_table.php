<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->string('id','33');
            $table->string('nama');
            $table->integer('harga_jawa')->nullable();
            $table->integer('harga_luar_jawa')->nullable();
            $table->integer('harga_batam')->nullable();
            $table->string('suplier')->nullable();
            $table->tinyInteger('hidden')->default(0);
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
        Schema::dropIfExists('items');
    }
}
