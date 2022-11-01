<?php

namespace App;

use App\Traits\HasRoles;
use App\Traits\SupervisorMethods;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    use Notifiable, HasRoles, SupervisorMethods;

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
     * Belongs to a supervisor
     *
     * @return BelongsTo
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(self::class, 'supervisor_id');
    }

    /**
     * Supervisor has bloggers
     *
     * @return HasMany
     */
    public function bloggers(): HasMany
    {
        return $this->hasMany(self::class, 'supervisor_id');
    }

    /**
     * User posts
     *
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    /**
     * get Post Count
     *
     * @return integer
     */
    public function postCount(): int
    {
        return [
            self::$blogger => $this->posts()->count(),
            self::$supervisor => $this->getSupervisorPostsQuery()->count(),
            self::$admin => Post::count()
        ][$this->user_type];
    }

    /**
     * Bloggers Count
     *
     * @return integer
     */
    public function bloggersCount(): int
    {
        return [
            self::$blogger => 0,
            self::$supervisor => $this->totalBloggers(),
            self::$admin => User::bloggerUsers()->count()
        ][$this->user_type];
    }

    /**
     * Retrieve Supervisors count
     *
     * @return integer
     */
    public function supervisorsCount(): int
    {
        return [
            self::$blogger => 0,
            self::$supervisor => 0,
            self::$admin => User::supervisors()->count()
        ][$this->user_type];
    }

    /**
     * Register user last login
     *
     * @return User
     */
    public function registerLogin(): User
    {
        $this->last_login = now();
        $this->save();

        return $this;
    }

    /**
     * Return initial filtered query for posts
     *
     * @return Builder
     */
    public function getPosts(): Builder
    {
        return [
            self::$blogger => Post::whereAuthorId($this->id),
            self::$supervisor => $this->getSupervisorPostsQuery(),
            self::$admin => Post::query()
        ][$this->user_type];
    }

    /**
     * Scope supervisor users
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeSupervisors(Builder $query): Builder
    {
        return $query->whereUserType(self::$supervisor);
    }

    /**
     * Scope blogger users
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeBloggerUsers(Builder $query): Builder
    {
        return $query->whereUserType(self::$blogger);
    }

    /**
     * Scope admin users
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAdmins(Builder $query): Builder
    {
        return $query->whereUserType(self::$admin);
    }

    /**
     * Bootting Model
     *
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();

        static::created(function ($model) {
            if (! $model->user_type) {
                $model->makeBlogger();
            }
        });
    }
}
