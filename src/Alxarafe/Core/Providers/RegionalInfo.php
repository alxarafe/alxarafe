<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Providers;

use Alxarafe\Core\Helpers\FormatUtils;

/**
 * Class RegionalInfo
 *
 * @package Alxarafe\Core\Providers
 */
class RegionalInfo
{
    use Singleton {
        getInstance as getInstanceTrait;
    }

    /**
     * Contains the config content.
     *
     * @var array
     */
    protected $configContent;

    /**
     * Container constructor.
     */
    public function __construct()
    {
        if (!isset($this->configContent)) {
            $this->separateConfigFile = false;
            $this->initSingleton();
            $this->getConfigContent();
        }
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
        if (empty($this->configContent)) {
            $this->configContent = $this->getConfig();
        }
        return $this->configContent;
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
        return [
            'dateFormat' => 'Y-m-d',
            'timeFormat' => 'H:i:s',
            'datetimeFormat' => 'Y-m-d H:i:s',
            'timezone' => 'Europe/Madrid',
        ];
    }

    /**
     * Returns a list of date formats
     */
    public function getDateFormats(): array
    {
        $styles = [
            'Y-m-d',
            'Y-m-j',
            'Y-M-d',
            'Y-M-j',
            'd-m-Y',
            'j-m-Y',
            'd-M-Y',
            'j-M-Y',
            'm-d-Y',
            'm-j-Y',
            'M-d-Y',
            'M-j-Y',
        ];
        return $this->fillList($styles);
    }

    /**
     * Fill list with key => value, where key is style and value a sample.
     *
     * @param array $styles
     *
     * @return array
     */
    private function fillList($styles): array
    {
        $result = [];
        foreach ($styles as $style) {
            $result[$style] = $this->getFormatted($style);
        }
        return $result;
    }

    /**
     * Return formatted string.
     *
     * @param string $style
     * @param string $time
     *
     * @return false|string
     */
    private function getFormatted(string $style, string $time = '2011-01-07 09:08:07')
    {
        return FormatUtils::getFormatted($style, $time);
    }

    /**
     * Returns a list of time formats
     */
    public function getTimeFormats(): array
    {
        $styles = [
            'H:i',
            'H:i:s',
            'h:i A',
            'h:i:s A',
        ];
        return $this->fillList($styles);
    }
}
