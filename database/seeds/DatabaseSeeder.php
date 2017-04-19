<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(IdiomaTableSeeder::class);
    	$this->call(PageTableSeeder::class);
    	$this->call(ZonasTableSeeder::class);
        $this->call(GuiasTableSeeder::class);
    }
}
