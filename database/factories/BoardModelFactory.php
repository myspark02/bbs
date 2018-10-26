<?php

use Faker\Generator as Faker;
use App\Board;

$factory->define(Board::class, function (Faker $faker) {
	$regtime = $faker->dateTimeBetween($startDate='-1 years', $endDate='now');
    return [
        'title' => $faker->word,
        'writer' => $faker->lastName, 
        'content' => $faker->realText($maxNbChars=200),
        'regtime'=>$regtime,
        'created_at'=>$regtime,
        'updated_at'=>$faker->dateTimeBetween($startDate=$regtime, $endDate='now'),
    ];
});
