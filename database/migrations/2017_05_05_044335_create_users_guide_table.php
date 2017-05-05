<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersGuideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	{
		Schema::create('user_guide', function (Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->integer('guide_id')->unsigned();
			/* No se que mas agregar aqui */

			$table->timestamps();
			$table->primary(['user_id', 'guide_id']);
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('guide_id')->references('id')->on('guias');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('user_guide');
    }
}
