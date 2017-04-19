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
            $table->string('name');

            $table->string('email');
            $table->string('password')->nullable();

            $table->integer('user_types_id')->unsigned();
            $table->integer('pages_id')->unsigned();
            $table->integer('referer_id')->unsigned()->nullable();
            $table->integer('monedas');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('user_types_id')->references('id')->on('user_types');
            $table->foreign('pages_id')->references('id')->on('pages');
            $table->foreign('referer_id')->references('id')->on('users');
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
