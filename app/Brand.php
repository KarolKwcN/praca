<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name' , 'description', 'category_id', 'slugi'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
        
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
