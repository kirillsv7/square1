<?php

namespace App\Cache;

use App\Contracts\RepositoryInterface;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Cache as CacheFacade;

abstract class Cache implements RepositoryInterface
{
    const TTL = 60 * 60;

    protected $cache;

    /**
     * @param  Repository  $repository
     */
    public function __construct(
        protected Repository $repository,
    ) {
        $this->cache = new CacheFacade();
    }

}