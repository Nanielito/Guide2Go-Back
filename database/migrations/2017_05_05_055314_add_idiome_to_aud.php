<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdiomeToAud extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('audios', function (Blueprint $table) {
			// Clave compuesta o id ?
			$table->integer('idiomas_id')
				->unsigned()
				->after('parada_id');

			$table->foreign('idiomas_id')
				->references('id')
				->on('idiomas');

		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
