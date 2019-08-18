<?php

namespace TinyPixel\Copernicus\Console\Scheduling;

use Illuminate\Console\Scheduling\Schedule as ScheduleBase;
use Illuminate\Contracts\Cache\Repository as Cache;

class Schedule extends ScheduleBase
{
    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Contracts\Cache\Repository $cache
     * @return void
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }
}
