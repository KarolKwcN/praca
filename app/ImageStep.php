<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageStep extends Model
{
    protected $fillable = [
        'image'
    ];

    public function steps()
    {
        return $this->belongsTo('App\Step','step_id');
    }
}
