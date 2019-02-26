<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

use Alxarafe\Helpers\FormatUtils;

/**
 * Class RegionalInfo
 *
 * @package Alxarafe\Providers
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
    public function getConfigContent()
    {
        if (empty($this->configContent)) {
            $this->configContent = $this->getConfig();
        }
        return $this->configContent;
    }

    /**
     * Return this instance.
     *
     * @return RegionalInfo
     */
    public static function getInstance(): self
    {
        return self::getInstanceTrait();
    }

    /**
     * Return a list of essential controllers.
     *
     * @return array
     */
    public function getDefaulValues()
    {
        return [
            'date-format' => '',
            'hour-format' => '',
            'date-hour-format' => '',
            'timezone' => '',
        ];
    }

    /**
     * Returns a list of date formats
     */
    public function getDateFormats()
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
     * Returns a list of time formats
     */
    public function getTimeFormats()
    {
        $styles = [
            'H:i',
            'H:i:s',
            'h:i A',
            'h:i:s A',
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
    private function fillList($styles)
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
}
