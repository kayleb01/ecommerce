<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;


class Media extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['ImageUrl'];

    public function model():MorphTo
    {
        return $this->morphTo(); 
    }

    public function getImageUrlAttribute()
    {
        return url('storage/media/product/'.$this->created_at->format('Y').'/'.$this->created_at->format('m').'/' . $this->filename);
    }
}
