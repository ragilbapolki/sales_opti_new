<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name','111');
            $table->string('username','111')->unique();
            $table->string('password','111');
            $table->integer('role_id')->unsigned();
            $table->string('jabatan');
            $table->string('kode_cabang','11');
            $table->string('hp','13');
            $table->integer('active')->default(1);
            $table->rememberToken();
            $table->timestamps();
            // $table->softDeletes();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
