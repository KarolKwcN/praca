<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Casts\CreateAtCast;

class Comment extends Model
{
       public function user()
    {
        return $this->belongsTo(User::class);
        
    }
    
         public function repair()
    {
        return $this->belongsTo(Repair::class);
    }

    protected $casts = [
       
        'created_at'        => CreateAtCast::class,
    ];

    protected $dates = ['created_at', 'updated_at'];

}
