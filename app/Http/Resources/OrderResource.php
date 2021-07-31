<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'quantity' => $this->quantity,
            'total' => $this->total,
            'price' => $this->price,
            'shipping_fee' => $this->shipping_fee,
            'order_number' => $this->order_number,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at->format('m-d-Y')
        ];
    }
}
