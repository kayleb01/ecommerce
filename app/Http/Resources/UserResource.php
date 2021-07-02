<?php

namespace App\Http\Resources;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'full_name' => $this->full_name,
            'username' => $this->username,
            'address' => $this->address,
            'role' => $this->role,
            'email' => $this->email,
            'company_name' => $this->company_name,
            'store_name' => $this->store_name,
            'state' => $this->state,
            'city' => $this->city,
            'zipcode' => $this->zipcode,
            'created_at' => $this->created_at->toDateTimeString()
        ];
        //return parent::toArray($request);
    }
}
