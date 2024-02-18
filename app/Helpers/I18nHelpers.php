<?php

namespace App\Helpers;

class I18nHelpers
{
    /**
     * Translate and return the array given in the current locale.
     * The array must be in the lang file format.
     *
     * @author Cayetano H. Osma <chernandez@elestadoweb.com>
     *
     * @version Feb.2024
     */
    public static function translateConfig(string $domain, array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $result[$key] = trans(sprintf('%s.%s', $domain, $value));
        }

        return $result;
    }

    /**
     * Return the available list of languages in ISO-639-1
     *
     * @author Cayetano H. Osma <chernandez@elestadoweb.com>
     *
     * @version Feb.2024
     */
    public static function getAvailableLanguages(): array
    {
        $languages = config('alxarafe.i18n.available_install_languages');
        $languageCodes = array_map(function ($item) {
            return strtok($item, '_');
        }, $languages);

        return array_unique($languageCodes, SORT_STRING);
    }
}
