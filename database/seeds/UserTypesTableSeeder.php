<?php

use App\User_type;
use Illuminate\Database\Seeder;

class UserTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User_type::store('admin');
        User_type::store('blogger');
        User_type::store('normal');
    }
}
