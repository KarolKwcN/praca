<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    public function repairs()
    {
        return $this->belongsTo('App\Repair','repair_id');
    }
}
