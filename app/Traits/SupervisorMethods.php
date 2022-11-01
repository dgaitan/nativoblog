<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait SupervisorMethods
{
    /**
     * Total Bloggers that this supervisor has
     *
     * @return integer
     */
    public function totalBloggers(): int
    {
        if (! $this->isSupervisor()) {
            return 0;
        }
        
        $cacheKey = sprintf('user_%s_bloggers_count', $this->id);
        
        if (Cache::has($cacheKey)) {
            return (int) Cache::get($cacheKey);
        }

        return Cache::remember($cacheKey, now()->addYear(), function () {
            return $this->bloggers()->count();
        });
    }

    /**
     * Get Blogger Ids
     *
     * @return array
     */
    public function bloggerIds(): array
    {
        if (! $this->isSupervisor()) {
            return [];
        }

        $cacheKey = sprintf('user_%s_blogger_ids', $this->id);

        return Cache::has($cacheKey)
            ? (array) Cache::get($cacheKey)
            : Cache::remember($cacheKey, now()->addYear(), function () {
                return $this->bloggers()->pluck('id')->toArray();
            });
    }
}