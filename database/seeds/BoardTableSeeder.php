<?php

use Illuminate\Database\Seeder;
use App\database\factories\BoardModelFactory;

class BoardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(App\Board::class, 50)->create();
        //App\Board::create();
    }
}
