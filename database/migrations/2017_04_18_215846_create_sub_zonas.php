<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubZonas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_zonas', function (Blueprint $table) {
            $table->increments('id');
            $table->polygon('poligono');
            $table->string('nombre')->nullable();
            $table->integer('zonas_id')->unsigned();
            $table->timestamps();

            $table->foreign('zonas_id')->references('id')->on('zonas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_zonas');
    }
}
