<?php

namespace App;
use App\Repair;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role' , 'user_role', 'user_id', 'role_id');
    }

        public function verifyUser()
    {
    return $this->hasOne('App\VerifyUser');
    }

    public function hasAnyRole($roles)
    {
        if(is_array($roles)){
            foreach($roles as $role){
                if ($this->hasRole($role)){
                    return true;
                }
            }
        }   else {
                if ($this->hasRole($roles)){
                    return true;
                }
        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()){
            return true;
        }
        return false;
    }

    public function repairs()
    {
        return $this->hasMany('App\Repair','user_id');
    }

 
   public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    

    
}
