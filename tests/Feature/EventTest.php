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

        $res->assertStatus(401);
    }

    public function test_UnAuthorized_cannot_Create_Events()
    {
        

        $res = $this->json('POST', 'api/events',
            ['Accept' => 'application/json', 'Content-type' => 'application/json']);

        $res->assertStatus(401);
    }

    public function test_Authorized_can_Access_Events()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $res = $this->json('GET', 'api/events',[],
            ['Accept' => 'application/json', 'Content-type' => 'application/json']);

        $res->assertStatus(200);
    }

    public function test_Authorized_can_see_Events()
    {
        $user = factory(User::class)->create();
        $event = factory(Event::class)->create();
        $event->users()->sync($user);
        Passport::actingAs($user);

        $res = $this->json('GET', 'api/events',[],
            ['Accept' => 'application/json', 'Content-type' => 'application/json']);
        
            //TODO make sure structure is currect
        $res->assertStatus(200);
    }

}
