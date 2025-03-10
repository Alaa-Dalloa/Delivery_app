<?php

namespace App\Models;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'blocked',
        'blocked_until',
        'points'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



     public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

   public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function addresses()
{
    return $this->belongsToMany(Address::class, 'address_user', 'user_id', 'address_id');
}

    public function orders()
   {
       return $this->hasMany(Order::class);
   }
    
    public function comment()
   {
       return $this->hasMany(Comment::class);
   }

    public function stars()
   {
       return $this->hasMany(Star::class);
   }

   public function users()
   {
       return $this->hasMany(User::class);
   }

    public function favorites()
{
    return $this->hasMany(Meal::class);
}
}
