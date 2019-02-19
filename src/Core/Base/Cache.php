<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Helpers\Config;
use Alxarafe\Providers\Logger;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\MemcachedAdapter;
use Symfony\Component\Cache\Adapter\PdoAdapter;
use Symfony\Component\Cache\Adapter\PhpArrayAdapter;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;
use Symfony\Component\Cache\Exception\CacheException;

/**
 * Class Cache. This class is fully supported with Symfony Cache.
 *
 * @doc https://symfony.com/doc/current/components/cache/cache_pools.html
 *
 * @package Alxarafe\Base
 */
class Cache
{
    /**
     * Default life time of cache.
     */
    const DEFAULT_LIFE_TIME = 0;

    /**pues
     *
     * @var PhpArrayAdapter|MemcachedAdapter|PdoAdapter|PhpFilesAdapter|FilesystemAdapter
     */
    private $engine;

    /**
     * TODO: Undocumented
     *
     * @var
     */
    private $prefix;

    /**
     * TODO: Undocumented
     *
     * @var
     */
    private $defaultLifeTime;

    /**
     * Cache constructor.
     *
     * @param string $prefix
     * @param int    $lifeTime
     */
    public function __construct(string $prefix = '', $lifeTime = self::DEFAULT_LIFE_TIME)
    {
        if ($this->engine === null) {
            $this->prefix = $prefix;
            $this->defaultLifeTime = $lifeTime;
        }
        if ($this->engine === null) {
            $this->connectMemcache();
        }
        if ($this->engine === null) {
            $this->connectPDO();
        }
        if ($this->engine === null) {
            $this->connectPhpFiles();
        }
        if ($this->engine === null) {
            $this->connectFilesystem();
        }
    }

    /**
     * Sets Memcache engine. Requires ext-memcached
     *
     * @doc https://symfony.com/doc/current/components/cache/adapters/memcached_adapter.html
     *
     * @return void
     */
    private function connectMemcache(): void
    {
        if (constant('CACHE_HOST') !== '' && \class_exists('Memcache')) {
            $client = MemcachedAdapter::createConnection(
                'memcached://' . constant('CACHE_HOST') . ':' . constant('CACHE_PORT')
            );
            $this->engine = new MemcachedAdapter(
                $client,
                $this->prefix,
                $this->defaultLifeTime
            );
        }
    }

    /**
     * Sets PDO engine.
     *
     * @doc https://symfony.com/doc/current/components/cache/adapters/pdo_doctrine_dbal_adapter.html
     *
     * @return void
     */
    private function connectPDO(): void
    {
        $dsn = '';
        $this->engine = new PdoAdapter(
            $dsn,
            $this->prefix,
            $this->defaultLifeTime
        );
    }

    /**
     * Sets PHP Files engine.
     *
     * @doc https://symfony.com/doc/current/components/cache/adapters/php_files_adapter.html
     *
     * @return void
     */
    private function connectPhpFiles(): void
    {
        $directory = null;
        try {
            $this->engine = new PhpFilesAdapter(
                $this->prefix,
                $this->defaultLifeTime,
                $directory
            );
        } catch (CacheException $e) {
            Logger::getInstance()::exceptionHandler($e);
            Config::setError($e->getMessage());
        }
    }

    /**
     * Sets Filesystem engine.
     *
     * @doc https://symfony.com/doc/current/components/cache/adapters/filesystem_adapter.html
     *
     * @return void
     */
    private function connectFilesystem(): void
    {
        $directory = null;
        $this->engine = new FilesystemAdapter(
            $this->prefix,
            $this->defaultLifeTime,
            $directory
        );
    }
}
