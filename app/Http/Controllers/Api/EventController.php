<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Resources\EventResource;

class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('eventAdmin')->only(['destroy', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Auth::user();
        $events = $user->events;
        return EventResource::collection($events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get user
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        // validate request
        if ($validator->fails()) {
            return response()
                ->json(['error' => $validator->errors()])
                ->setStatusCode(400);
        }

        // create Event
        $input = $request->all(['name', 'type']);
        $event = new Event($input);
        $user->managedEvents()->save($event);

        $event->users()->attach($user);

        return new EventResource($event);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
        return new EventResource($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'users_id' => 'required|array',
        ]);

        // validate request
        if ($validator->fails()) {
            return response()
                ->json(['error' => $validator->errors()])
                ->setStatusCode(400);
        }

        $users_id = $request->input('users_id');

        $event->users()->sync($users_id);

        // update friend list
        $user->addFriends($users_id);
        // remove the requester from his/her friendship list
        $user->removeFriends($user);


        return new EventResource($event);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Event $event
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Event $event)
    {
        $event->users->each(function ($user) use ($event) {
            $user->events()->detach($event);
        });
        $event->delete();
        return new EventResource($event);

    }
}
