<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'products';

    protected $fillable  = ['title', 'description', 'status', 'price', 'total_stock', 'sold_stock', 'category_id', 'vendor_id', 'user_id', 'slug', 'discounted_price'];


    protected static function boot()
    {
        parent::boot();
        static::created(function ($product) {
            $product->update(['slug' => $product->title]);
        });
    }

    //model relationships

    public function category()
    {
       return $this->belongsTo(Category::class, 'category_id');
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'vendor_id');
    }

    public function user()
    {
       return $this->belongsTo(User::class, 'user_id');
    }

    public function setSlugAttribute($value){

        if (static::whereSlug($slug = Str::slug($value))->exists()) {
                $slug = "{$slug}-{$this->id}";
            }

        $this->attributes['slug'] = $slug;
    }
}
