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
    	//factory(App\Board::class, 50)->create();
        //App\Board::create();

        $bs = App\Board::all();
        $min = 10;
        $max = \App\Board::max('id');
        foreach($bs as $b) {
            $faker = \Faker\Factory::create();

            $uid = $faker->numberBetween($min, $max);
            $b->update(['user_id'=>$uid]);
        }
    }
}
