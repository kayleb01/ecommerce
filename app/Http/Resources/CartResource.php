<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'price' => number_format($this->price / 100, 2, '.', ','),
            'total' => number_format($this->total / 100, 2, '.', ','),
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
             'product' => $this->product

        ];
    }
}
