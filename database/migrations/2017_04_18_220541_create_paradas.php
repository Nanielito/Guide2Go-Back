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
            $table->integer('sub_zonas_id')->unsigned();
            /* Id de categorias */

            $table->string('nombre');
            $table->longText('descripcion');
            $table->point('punto');

            $table->foreign('sub_zonas_id')->references('id')->on('sub_zonas');

            /* Clave foranea de categorias */
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
