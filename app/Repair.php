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
        return $this->hasMany(Step::class);
    }

    public function users()
    {
        return $this->belongsTo('\App\User','user_id');
    }

    public function devices()
    {
        return $this->hasOne(Device::class);
    }
}
