<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddZoneToGuide extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guias', function(Blueprint $table) {

            $table->integer('zonas_id')
                ->unsigned()
                ->after('id');
            
            $table->foreign('zonas_id')
                ->references('id')
                ->on('zonas')
                ->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guias', function(Blueprint $table) {

            $table->dropForeign('guias_zonas_id_foreign');
            $table->dropColumn('zonas_id');

        });
    }
}
