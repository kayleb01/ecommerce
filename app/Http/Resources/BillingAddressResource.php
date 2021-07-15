<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillingAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'user_id' => $this->user_id,
            'address' => $this->address,
            'state' => $this->state,
            'city' => $this->city,  
            'zipcode' => $this->zipcode,
            'phone' => $this->phone,
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}
