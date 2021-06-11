<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'price' => number_format($this->price / 100, 2, '.', ','),
            'total_stock' => $this->total_stock,
            'category_id' => $this->category_id,
            'vendor_id' => $this->vendor_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at->format('d-m-Y H:i:s')
        ];
    }
}
