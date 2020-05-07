<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {

    $name = ['Fanateer', 'Khobar', 'Rumanah', 'Starbucks', 'Ju Sameen'];
    $type = ['beach', 'trip', 'restuarant', 'coffee', 'camp'];
    $picker = $faker->numberBetween(0,4);
    return [
        'name' => $name[$picker],
        'type' => $type[$picker]
    ];
});
