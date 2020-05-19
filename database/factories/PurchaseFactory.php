<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use App\Purchase;
use App\User;
use Faker\Generator as Faker;

$factory->define(Purchase::class, function (Faker $faker) {

    $event = Event::all()->random();
    $user = $event->users->random();
    return [
        'event_id' => $event->id,
        'user_id' => $user->id,
        'itemName' => $faker->word(),
        'cost' => $faker->randomFloat(1, 100),
    ];
});
