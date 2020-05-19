<?php

namespace Tests\Feature\Purchase;

use App\Event;
use App\Purchase;
use App\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;

class DestroyPurchaseTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed --class EventTableSeeder');
        $this->artisan('db:seed --class PurchaseTableSeeder');

    }

    public function test_admin_cannot_delete_Purchase()
    {
        $event = Event::first();
        $user = factory(User::class)->create();
        $event->users()->attach($user, ['active' => 1]);

        $purhcase = new Purchase(['user_id' => $user->id, 'event_id'=>$event->id, 'itemName'=>'test', 'cost'=>100]);
        $event->purchases()->save($purhcase);

        $admin = $event->admin;

        Passport::actingAs($admin);

        $res = $this->json('Delete', ('api/purchases/' . $purhcase->id),
            [],
            ['Accept' => 'application/json', 'Content-type' => 'application/json']);

        $res->assertForbidden();
    }

    public function test_owner_can_delete_Purchase()
    {

        $purhcase = Purchase::first();
        $event = $purhcase->event;
        $user = $purhcase->user;
        $admin = $event->admin;

        Passport::actingAs($user);


        $res = $this->json('Delete', ('api/purchases/' . $purhcase->id),
            [],
            ['Accept' => 'application/json', 'Content-type' => 'application/json']);

        $this->assertDeleted($purhcase);
    }

    public function test_others_cannot_delete_Purchase()
    {

        $purhcase = Purchase::first();
        $event = $purhcase->event;
        $user = $purhcase->user;
        $admin = $event->admin;
        $newUser = factory(User::class)->create();
        $event->users()->attach($newUser, ['active' => true]);
        Passport::actingAs($newUser);


        $res = $this->json('Delete', ('api/purchases/' . $purhcase->id),
            [],
            ['Accept' => 'application/json', 'Content-type' => 'application/json']);

        $this->assertDatabaseHas('purchases', ['id' =>$purhcase->id]);
    }

    public function test_others_Not_Allowed_to_delete_Purchase_Error403()
    {
        $purhcase = Purchase::first();
        $event = $purhcase->event;
        $user = $purhcase->user;
        $admin = $event->admin;
        $newUser = factory(User::class)->create();
        $event->users()->attach($newUser, ['active' => true]);
        Passport::actingAs($newUser);


        $res = $this->json('Delete', ('api/purchases/' . $purhcase->id),
            [],
            ['Accept' => 'application/json', 'Content-type' => 'application/json']);

        $res->assertForbidden();
    }


}
