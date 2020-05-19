<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use App\User;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {

    $name = ['Fanateer', 'Khobar', 'Rumanah', 'Starbucks', 'Ju Sameen', 'خيمة سهيل'];
    $type = ['beach', 'trip', 'restaurant', 'coffee', 'camping', 'home'];

    $picker = $faker->numberBetween(0,5);


    return [
        'name' => $name[$picker],
        'type' => $type[$picker],
    ];

});
