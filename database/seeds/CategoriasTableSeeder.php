<?php

use Illuminate\Database\Seeder;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$categories = ['Museo', 'Galeria', 'Parque', 'Carniceria', 'Pucha'];
        foreach ($categories as $cat) {
        	App\Categoria::store($cat);
        }
    }
}
