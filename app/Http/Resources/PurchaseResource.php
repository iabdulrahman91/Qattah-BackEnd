<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
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
            'event_id' => $this->event_id,
            'itemName' => $this->itemName,
            'cost' => $this->cost,
            ];
    }
}
