<?php

namespace Tests\Feature;

use App\User;
use App\Event;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase, withFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_UnAuthorized_cannot_Access_Events()
    {
        

        $res = $this->json('GET', 'api/events',
            ['Accept' => 'application/json', 'Content-type' => 'application/json']);

        $res->assertUnauthorized();
    }

    public function test_UnAuthorized_cannot_Create_Events()
    {
        

        $res = $this->json('POST', 'api/events',
            ['Accept' => 'application/json', 'Content-type' => 'application/json']);

        $res->assertUnauthorized();
    }

    public function test_Authorized_can_Access_Events()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $res = $this->json('GET', 'api/events',[],
            ['Accept' => 'application/json', 'Content-type' => 'application/json']);

        $res->assertSuccessful();
    }

    public function test_Authorized_can_see_Events()
    {
        $user = factory(User::class)->create();
//        $user->managedEvent()->save(factory(Event::class)->create());
        $event = factory(Event::class)->make();
        $user->managedEvents()->save($event);
//        $user->events()->attach($event, ['active' => true]);
        Passport::actingAs($user);

        $res = $this->json('GET', 'api/events',[],
            ['Accept' => 'application/json', 'Content-type' => 'application/json']);
        $res->assertJsonStructure(["data"]);
    }

}
