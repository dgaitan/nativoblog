<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App/User
 * 
 * @property string $name
 * @property string|null $last_name
 * @property string $email
 * @property string $password
 * @property int $user_type
 * @property \Illuminate\Support\Carbon $last_login
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * User Types or Lever
     */
    public const BLOGGER_TYPE = 3;
    public const SUPERVISOR = 2;
    public const ADMIN = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name', 'email', 'password',
        'user_type', 'last_name', 'last_login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, mixed>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
    ];

    /**
     * Retrieve the available user types
     *
     * @return array
     */
    public static function getUserTypes(): array
    {
        return [
            self::BLOGGER_TYPE => 'Blogger',
            self::SUPERVISOR => 'Supervisor',
            self::ADMIN => 'Admin',
        ];
    }
}
