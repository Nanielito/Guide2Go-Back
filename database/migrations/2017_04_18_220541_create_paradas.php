<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParadas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paradas', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('descripcion');
            $table->string('nombre');
            $table->integer('sub_zonas_id')->unsigned();
            $table->point('punto');
            $table->integer('categoria_id')->unsigned();

            $table->foreign('sub_zonas_id')->references('id')->on('sub_zonas');
            $table->foreign('categoria_id')->references('id')->on('categoria_paradas');
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
        Schema::dropIfExists('paradas');
    }
}
