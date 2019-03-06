<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Helpers;

use Alxarafe\Core\Providers\RegionalInfo;
use DateTime;

/**
 * Class FormatUtils, this class simplifies the way to get the final format for date, time and datetime.
 *
 * @package Alxarafe\Core\Helpers
 */
class FormatUtils
{
    /**
     * Config fields.
     *
     * @var array
     */
    private static $config;

    /**
     * Time zone to use.
     *
     * @var string
     */
    private static $timeZone;

    /**
     * Date format to use.
     *
     * @var string
     */
    private static $dateFormat;

    /**
     * Time format to use.
     *
     * @var string
     */
    private static $timeFormat;

    /**
     * Date time format to use.
     *
     * @var string
     */
    private static $datetimeFormat;

    /**
     * Returns the format for date.
     *
     * @return string
     */
    public static function getFormatDate(): string
    {
        return self::$dateFormat;
    }

    /**
     * Load config.
     */
    public static function loadConfig(): void
    {
        self::$config = RegionalInfo::getInstance()->getConfig();
        if (!empty(self::$config)) {
            self::$timeZone = self::$config['timezone'];
            // Sets the default timezone to use
            date_default_timezone_set(self::$config['timezone']);
            self::$dateFormat = self::$config['dateFormat'];
            self::$timeFormat = self::$config['timeFormat'];
            self::$datetimeFormat = self::$config['datetimeFormat'];
        }
    }

    /**
     * Returns the format for date time.
     *
     * @return string
     */
    public static function getFormatDateTime(): string
    {
        return self::$datetimeFormat;
    }

    /**
     * Returns the format for time.
     *
     * @return string
     */
    public static function getFormatTime(): string
    {
        return self::$timeFormat;
    }

    /**
     * Return date formatted.
     *
     * @param string $date
     *
     * @return string
     */
    public static function getFormattedDate(string $date = ''): string
    {
        return self::getFormatted(self::$dateFormat, $date);
    }

    /**
     * Return formatted string.
     *
     * @param string $style
     * @param string $time
     *
     * @return string
     */
    public static function getFormatted(string $style = '', string $time = ''): string
    {
        try {
            $time = ($time === '') ? 'now' : $time;
            $date = (new DateTime($time))->format($style);
        } catch (\Exception $e) {
            $time = ($time === '') ? 'time()' : $time;
            $date = date($style, strtotime($time));
        }
        return $date;
    }

    /**
     * Return date formatted.
     *
     * @param string $date
     *
     * @return string
     */
    public static function getFormattedTime(string $date = ''): string
    {
        return self::getFormatted(self::$timeFormat, $date);
    }

    /**
     * Return date formatted.
     *
     * @param string $date
     *
     * @return string
     */
    public static function getFormattedDateTime(string $date = ''): string
    {
        return self::getFormatted(self::$datetimeFormat ?? '', $date);
    }
}
