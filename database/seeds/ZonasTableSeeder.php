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
        factory(App\Zona::class, 50)->create();
    }
}
