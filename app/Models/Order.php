<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";
    protected $fillable = ['user_id', 'quantity', 'total', 'price', 'shipping_fee', 'order_number', 'payment_status'];

  public function product()
    {
       return $this->belongsToMany(Product::class)->withTimestamps();
    }

    function different_shops($array) {
        return count($array) !== count(array_unique($array));
     }

}
