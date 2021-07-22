<?php

namespace App\Http\Resources;
use App\Models\Shop;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
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
            'name' => $this->name,
            'address' => $this->address,
            'description' => $this->description,
            'product' => $this->product,
            'created_at' => $this->created_at->toDateTimeString()
            ];
    }
}
