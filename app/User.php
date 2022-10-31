<?php

namespace App;

use Exception;
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
    public const BLOGGER = 3;
    public const SUPERVISOR = 2;
    public const ADMIN = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name', 'email', 'password',
        'last_name',
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
     * Make a user a blogger
     *
     * @return User
     */
    public function makeBlogger(): User
    {
        return $this->changeUserType(self::BLOGGER);
    }

    /**
     * Make a user a Supervisor
     *
     * @return User
     */
    public function makeSupervisor(): User
    {
        return $this->changeUserType(self::SUPERVISOR);
    }

    /**
     * Make a user an admin
     *
     * @return User
     */
    public function makeAdmin(): User
    {
        return $this->changeUserType(self::ADMIN);
    }

    /**
     * Change user type/permission level
     *
     * @param integer $userType
     * @return User
     */
    protected function changeUserType(int $userType): User
    {
        if (! in_array($userType, array_keys(self::getUserTypes()))) {
            throw new Exception('Invalid user type! Please try with a valid user type code');
        }

        $this->update(['user_type' => $userType]);

        return $this;
    }

    /**
     * Retrieve the available user types
     *
     * @return array
     */
    public static function getUserTypes(): array
    {
        return [
            self::BLOGGER => 'Blogger',
            self::SUPERVISOR => 'Supervisor',
            self::ADMIN => 'Admin',
        ];
    }
}
