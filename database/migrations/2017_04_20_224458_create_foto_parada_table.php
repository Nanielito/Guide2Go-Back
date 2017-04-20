<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotoParadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('parada_id');
            $table->timestamps();

            $table->foreign('parada_id')->references('id')->on('paradas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fotos');
    }
}
