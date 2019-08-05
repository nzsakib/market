<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const TYPE_CUSTOMER = 1;
    const TYPE_VENDOR = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type'
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

    public function verificationToken()
    {
        return $this->hasOne(Token::class);
    }

    public function generateToken()
    {
        $token = Str::random(40);
        while ($this->verificationToken()->where('token', $token)->exists()) {
            $token = Str::random(40);
        }

        return $this->verificationToken()->create(['token' => $token]);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function profilePath()
    {
        if ($this->type == self::TYPE_CUSTOMER) {
            return route('customer.profile');
        }
    }
}
