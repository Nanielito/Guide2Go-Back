<?php

use Illuminate\Database\Seeder;

class ZonasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $zones = factory(App\Zona::class, 50)->create();
        $this->randSubZones($zones);
    }

    private function randSubZones($zones) {
    	$zones->each(function ($z) {
        	$many = rand() % 10 + 1;
        	$subZones = factory(App\Sub_zona::class, $many)
        		->make(['zonas_id' => $z->id]);

        	/* Sweeeeet */
        	$subZones = $z->subZonas()->saveMany($subZones);
        	$this->randParadas($subZones);
        });
    }

    private function randParadas($subZones) {
    	$subZones->each(function ($sZ) {
    		$many = rand() % 10 + 1;
	    	$paradas = factory(App\Parada::class, $many)
	    		->make(['sub_zonas_id' => $sZ->id]);

	    	$sZ->paradas()->saveMany($paradas);
    	});
    }
}
