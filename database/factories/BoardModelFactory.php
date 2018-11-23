<?php

use Faker\Generator as Faker;
use App\Board;
use App\User;

$factory->define(Board::class, function (Faker $faker) {
	$regtime = $faker->dateTimeBetween($startDate='-1 years', $endDate='now');
	$minid = User::min('id');
	$maxid = User::max('id');
	$user_id = $faker->numberBetween($minid, $maxid);
    return [
        'title' => $faker->word,
       /* 'writer' => $faker->lastName, */ 
        'content' => $faker->realText($maxNbChars=200),
        'regtime'=>$regtime,
        'created_at'=>$regtime,
        'updated_at'=>$faker->dateTimeBetween($startDate=$regtime, $endDate='now'),
        'user_id' => 70/*$user_id*/,
    ];
});
