<?php

use Illuminate\Database\Seeder;

class GuiasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
        factory(App\Guia::class, 100)->create();
    }
}
