<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\Trackable;
use Laravel\Passport\HasApiTokens;

use App\Models\UserBridge;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Trackable, HasApiTokens;

    const ADMIN_ROLE = 'admin';
    const DEFAULT_ROLE = 'employee';

    /*
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'profile_image'
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

    public function isAdmin() {
        return $this->type === self::ADMIN_ROLE;
    }

    public function user_bridge() 
    { 
        return $this->hasMany(UserBridge::class); 
    }
}
