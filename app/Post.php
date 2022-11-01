<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    /**
     * Fillable Fields
     *
     * @var array<string>
     */
    protected $fillable = [
        'title', 'content', 'author_id'
    ];

    /**
     * Post author
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get Edit Link
     *
     * @return string
     */
    public function getEditLink(): string
    {
        return route('app.posts.edit', [
            'post' => $this
        ]);
    }

    /**
     * Get Dtail Link
     *
     * @return string
     */
    public function getDetailLink(): string
    {
        return route('app.posts.detail', [
            'post' => $this
        ]);
    }

    /**
     * GEt Update Action Link
     *
     * @return string
     */
    public function getUpdateActionLink(): string
    {
        return route('app.posts.update', [
            'post' => $this
        ]);
    }

    /**
     * Get Delete Action Link
     *
     * @return string
     */
    public function getDeleteActionLink(): string
    {
        return route('app.posts.delete', [
            'post' => $this
        ]);
    }
}
