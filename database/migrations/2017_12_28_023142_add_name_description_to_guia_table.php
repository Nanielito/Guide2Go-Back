<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameDescriptionToGuiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guias', function (Blueprint $table) {
            $table->string('nombre', 50)
                ->after('idiomas_id');

            $table->string('descripcion', 255)
                ->after('nombre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guias', function (Blueprint $table) {
            $table->dropColumn(['nombre', 'descripcion']);
        });
    }
}
