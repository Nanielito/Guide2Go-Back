<?php

use Illuminate\Database\Seeder;

class SubZonaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Sub_zona::class, 10)->create();
    }
}
