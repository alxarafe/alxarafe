<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Providers\Singleton;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\PhpArrayAdapter;

/**
 * Class CacheCore. This class is fully supported with Symfony Cache.
 *
 * @doc https://symfony.com/doc/current/components/cache/cache_pools.html
 *
 * @package Alxarafe\Base
 */
class CacheCore
{
    use Singleton {
        getInstance as getInstanceTrait;
    }

    /**
     * Default life time of cache.
     */
    const DEFAULT_LIFE_TIME = 0;

    /**
     * Engine to cache data.
     *
     * @var PhpArrayAdapter
     */
    private $engine;

    /**
     * Defautl max time to life.
     *
     * @var int
     */
    private $defaultLifeTime;

    /**
     * CacheCore constructor.
     *
     * @param int $lifeTime
     */
    public function __construct($lifeTime = self::DEFAULT_LIFE_TIME)
    {
        if (!isset($this->engine)) {
            $this->initSingleton();
            $this->defaultLifeTime = $lifeTime;
            $this->connectPhpArray();
            if (constant('CORE_CACHE_ENABLED') !== true) {
                $this->engine->clear();
            }
        }
    }

    /**
     * Sets PhpArray engine.
     *
     * @doc https://symfony.com/doc/current/components/cache/adapters/php_array_cache_adapter.html
     *
     * @return void
     */
    private function connectPhpArray(): void
    {
        $file = basePath('core.cache');
        $this->engine = new PhpArrayAdapter($file, new FilesystemAdapter());
    }

    /**
     * Return this instance.
     *
     * @return CacheCore
     */
    public static function getInstance(): self
    {
        return self::getInstanceTrait();
    }

    /**
     * Give access to the cache engine.
     *
     * @return PhpArrayAdapter
     */
    public function getEngine(): PhpArrayAdapter
    {
        return $this->engine;
    }
}
