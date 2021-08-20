<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Providers;

use Alxarafe\Core\Base\Provider;

/**
 * Class RegionalInfo
 *
 * @package Alxarafe\Core\Providers
 */
abstract class ConfigProvider extends Provider
{
    /**
     * Contains the config content.
     *
     * @var array
     */
    protected static array $configContent;

    /**
     * Container constructor.
     */
    public function __construct()
    {
        parent::__construct();

        self::$separateConfigFile = false;
        self::getConfigContent();
    }

    /**
     * Returns the config content.
     * If config content is empty, load from file.
     * Otherwise return data from property.
     *
     * @return array
     */
    public function getConfigContent(): array
    {
        if (empty(self::$configContent)) {
            self::$configContent = self::getConfig();
        }
        return self::$configContent;
    }

}