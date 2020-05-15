<?php

namespace App\Http\Resources;

use App\Event;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => new UserResource(User::find($this->user_id)),
            'receiver_id' => new UserResource(User::find($this->receiver_id)),
            'event_id' => $this->event_id,
            'amount' => $this->amount,
        ];
    }
}
