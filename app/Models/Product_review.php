<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_review extends Model
{
    use HasFactory;

    protected $table = 'product_reviews';
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'review',
        'status'
    ];
}
