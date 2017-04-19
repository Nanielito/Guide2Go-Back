<?php

use App\Idioma;
use Illuminate\Database\Seeder;

class IdiomaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Idioma::store('español');
        Idioma::store('english');
    }
}
