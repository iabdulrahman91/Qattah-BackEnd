<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class EventResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'admin' => new UserResource($this->admin),
            'users' => UserResource::collection($this->users),
            'purchases' => PurchaseResource::collection($this->purchases),
            'payments' => PaymentResource::collection($this->payments),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
