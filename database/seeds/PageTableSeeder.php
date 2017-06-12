<?php

use App\Page;
use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Page::store('Guide2Go');
        Page::store('facebook');
        Page::store('gmail');
    }
}
