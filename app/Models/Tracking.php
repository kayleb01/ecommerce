<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'order_id', 'status', 'points', 'destination', 'order_number'];

    public function setPointsAttribute($value)
    {
        $this->attributes['points'] = json_encode($value);
    }

    public function getPointsAttribute($value)
    {
       return json_decode($value);
    }

    #----------------Relationship------------------#

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
