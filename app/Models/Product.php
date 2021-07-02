<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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

    /**
     *
     * A reply has many attachments i.e pictures of whatever
     *  @return \Illuminate\Database\Eloquent\Relations\MorphMany
     * */
    public function product_review():MorphMany
    {
        return $this->morphMany(Product_review::class, 'reviewable');
    }

    public function isReviewed($id)
    {
       return $this->product_review()->where(['reviewable_id' => $id, 'user_id' => auth()->id()])->exists();
    }
}
