<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

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
        if ($this->engine === null) {
            $this->defaultLifeTime = $lifeTime;
        }
        if ($this->engine === null) {
            $this->connectPhpArray();
            //$this->engine->clear();
        }
    }

    /**
     * Sets PhpArray engine.
     *
     * @doc https://symfony.com/doc/current/components/cache/adapters/php_array_cache_adapter.html
     */
    private function connectPhpArray()
    {
        $file = constant('BASE_PATH') . constant('DIRECTORY_SEPARATOR') . 'core.cache';
        $this->engine = new PhpArrayAdapter(
            $file,
            new FilesystemAdapter()
        );
    }

    /**
     * Give access to the cache engine.
     *
     * @return PhpArrayAdapter
     */
    public function getEngine()
    {
        return $this->engine;
    }
}
