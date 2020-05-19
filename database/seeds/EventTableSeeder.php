<?php

use App\Event;
use Illuminate\Database\Seeder;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\User::class, 10)->create()->each(function ($user) {
            foreach (range(1,rand(2,5)) as $i){
                $event = factory(App\Event::class)->make();
                $user->managedEvents()->save($event);
                $user->events()->attach($event, ['active' => true]);
            }

        });

    }
}
