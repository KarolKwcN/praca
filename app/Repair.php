<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    protected $fillable = [
        'name' , 'description' , 'image'
    ];

    public function steps()
    {
        return $this->hasMany('App\Step','repair_id');
    }

    public function users()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function devices()
    {
        return $this->hasOne(Device::class);
    }
}