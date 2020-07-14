<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Providers\Singleton;
use Alxarafe\Core\Providers\Translator;
use Exception;
use RuntimeException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\PhpArrayAdapter;

/**
 * Class CacheCore. This class is fully supported with Symfony Cache.
 *
 * @doc https://symfony.com/doc/current/components/cache/cache_pools.html
 *
 * @package Alxarafe\Core\Base
 */
class CacheCore
{
    use Singleton {
        getInstance as getInstanceTrait;
    }

    /**
     * Default life time of cache.
     */
    public const DEFAULT_LIFE_TIME = 0;

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
        if (!file_exists($file) && file_put_contents($file, '') === false) {
            try {
                $message = Translator::getInstance()->trans('file-not-created', ['%file%' => $file]);
                throw new RuntimeException($message);
            } catch (Exception $e) {
                FlashMessages::getInstance()::setError($e->getMessage());
            }
        }
        $this->engine = new PhpArrayAdapter($file, new FilesystemAdapter());
    }

    /**
     * Return this instance.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        return self::getInstanceTrait();
    }

    /**
     * Return default values
     *
     * @return array
     */
    public static function getDefaultValues(): array
    {
        // Not really needed
        return [];
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
