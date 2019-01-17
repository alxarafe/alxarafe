<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use Symfony\Component\Translation\{Loader\YamlFileLoader, Translator};
use Symfony\Component\Yaml\{Exception\ParseException, Yaml};

/**
 * Class Lang, give support to internationalization.
 *
 * @package Alxarafe\Helpers
 */
class Lang
{
    /**
     * Default language to use if language file not exists.
     */
    const FALLBACK_LANG = 'en_EN';

    /**
     * Base folder where languages files are stored.
     */
    const LANG_FOLDER = BASE_PATH . '/src/Core/Languages';

    /**
     * Default language to use.
     */
    const LANG = 'es_ES';

    /**
     * Extension of language file.
     */
    const EXT = '.yaml';

    /**
     * Format of language file.
     */
    const FORMAT = 'yaml';

    /**
     * Default language.
     *
     * @var string
     */
    private static $defaultLang;

    /**
     * Loaded languages.
     *
     * @var array
     */
    private static $languages;

    /**
     * List of strings without translation.
     *
     * @var array
     */
    private static $missingStrings;

    /**
     * The Symfony translator.
     *
     * @var Translator
     */
    private static $translator;

    /**
     * List of used strings.
     *
     * @var array
     */
    private static $usedStrings;

    /**
     * Lang constructor.
     *
     * @param string $lang
     */
    public function __construct(string $lang = self::FALLBACK_LANG)
    {
        if (self::$translator === null) {
            self::$defaultLang = $lang;
            Debug::addMessage('messages', "Language '$lang' (default)");
            self::$missingStrings = [];
            self::$usedStrings = [];
            self::$translator = new Translator($lang);
            self::$translator->addLoader(self::FORMAT, new YamlFileLoader());
            if ($lang !== self::FALLBACK_LANG) {
                $this->locateFiles(self::FALLBACK_LANG);

            }
            $this->locateFiles($lang);
        }
    }

    /**
     * Load the translation files following the priority system of FacturaScripts.
     * In this case, the translator must be provided with the routes in reverse order.
     *
     * @param string $lang
     */
    private function locateFiles(string $lang)
    {
        self::$languages[] = $lang;
        $file = self::LANG_FOLDER . '/' . $lang . self::EXT;

        try {
            Yaml::parseFile($file);
            self::$translator->addResource(self::FORMAT, $file, $lang);
        } catch (ParseException $exception) {
            die((str_replace(constant('BASE_PATH'), '', $exception->getMessage())));
            //throw new Exception((str_replace(constant('BASE_PATH'), '', $exception->getMessage())));
        }

        /**
         * TODO: Esperando a ver como cargaremos los plugins
         * $pluginManager = new PluginManager();
         * foreach ($pluginManager->enabledPlugins() as $pluginName) {
         *     $file = constant('BASE_PATH') . '/Plugins/' . $pluginName . '/Translation/' . $lang . self::EXT;
         *     if (file_exists($file)) {
         *         self::$translator->addResource(self::FORMAT', $file, $lang);
         *     }
         * }
         */
    }

    /**
     * Returns the language code in use.
     *
     * @return string
     */
    public function getLangCode()
    {
        return self::$defaultLang;
    }

    /**
     * Sets the language code in use.
     *
     * @param string $lang
     */
    public function setLangCode(string $lang)
    {
        self::$defaultLang = $this->firstMatch($lang);
    }

    /**
     * Return first exact match, or first partial match with language key identifier,
     * or it not match founded, return default language.
     *
     * @param string $langCode
     *
     * @return string
     */
    private function firstMatch(string $langCode): string
    {
        $finalKey = null;
        // First match is with default lang? (Avoid match with variants)
        if (0 === strpos(self::LANG, $langCode)) {
            return self::LANG;
        }
        // If not, check with all available languages
        foreach ($this->getAvailableLanguages() as $key => $language) {
            if ($key === $langCode) {
                return $key;
            }
            if ($finalKey === null && 0 === strpos($key, $langCode)) {
                $finalKey = $key;
            }
        }
        return $finalKey ?? self::LANG;
    }

    /**
     * Returns an array with the languages with available translations.
     *
     * @return array
     */
    public function getAvailableLanguages()
    {
        $languages = [];
        $dir = self::LANG_FOLDER;
        foreach (scandir($dir, SCANDIR_SORT_ASCENDING) as $fileName) {
            if ($fileName !== '.' && $fileName !== '..' && !is_dir($fileName) && substr($fileName, -5) === self::EXT) {
                $key = substr($fileName, 0, -5);
                $languages[$key] = $this->trans('languages-' . substr($fileName, 0, -5));
            }
        }
        return $languages;
    }

    /**
     * Translate the text into the default language.
     *
     * @param null|string $txt
     * @param array       $parameters
     *
     * @return string
     */
    public function trans($txt, array $parameters = [])
    {
        if (is_null($txt)) {
            return '';
        }

        if (empty($txt)) {
            return '';
        }
        return $this->customTrans(self::$defaultLang, $txt, $parameters);
    }

    /**
     * Translate the text into the selected language.
     *
     * @param string $lang
     * @param string $txt
     * @param array  $parameters
     *
     * @return string
     */
    public function customTrans(string $lang, string $txt, array $parameters = [])
    {
        if (!in_array($lang, self::$languages)) {
            $this->locateFiles($lang);
        }
        $catalogue = self::$translator->getCatalogue($lang);
        if ($catalogue->has($txt)) {
            self::$usedStrings[$txt] = $catalogue->get($txt);
            return self::$translator->trans($txt, $parameters, null, $lang);
        }
        self::$missingStrings[$txt] = $txt;
        if ($lang === self::FALLBACK_LANG) {
            return $txt;
        }
        return $this->customTrans(self::FALLBACK_LANG, $txt, $parameters);
    }

    /**
     * Returns the missing strings.
     *
     * @return array
     */
    public function getMissingStrings()
    {
        return self::$missingStrings;
    }

    /**
     * Returns the strings used.
     *
     * @return array
     */
    public function getUsedStrings()
    {
        return self::$usedStrings;
    }
}