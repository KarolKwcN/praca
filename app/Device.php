<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'name' , 'description'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
        
    }

    public function repairs()
    {
        return $this->hasMany('App\Repair','device_id');
    }
}
