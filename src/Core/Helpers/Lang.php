<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\Translator;

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
    const FALLBACK_LANG = 'en';

    /**
     * Base folder where languages files are stored.
     */
    const LANG_FOLDER = '/Languages';

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

    protected $basePath;

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
     * List of strings without translation.
     *
     * @var array
     */
    private static $missingStrings;

    /**
     * Lang constructor.
     *
     * @param string $lang
     * @param string $basePath
     */
    public function __construct(string $lang = self::FALLBACK_LANG, string $basePath = ALXARAFE_FOLDER)
    {
        if (self::$translator === null) {
            $this->basePath = $basePath;
            self::$translator = new Translator($lang);
            self::$translator->setFallbackLocales([self::FALLBACK_LANG]);
            self::$translator->addLoader(self::FORMAT, new YamlFileLoader());
            self::$usedStrings = [];
            self::$missingStrings = [];

            $this->loadLangFiles();
        }
    }

    /**
     * Load the translation files following the priorities.
     * In this case, the translator must be provided with the routes in reverse order.
     *
     * @return void
     */
    private function loadLangFiles(): void
    {
        $langFiles = Finder::create()
            ->files()
            ->name('*' . self::EXT)
            ->in($this->getLangFolders())
            ->sortByName();
        foreach ($langFiles as $langFile) {
            $langCode = str_replace(self::EXT, '', $langFile->getRelativePathName());
            self::$translator->addResource(self::FORMAT, $langFile->getPathName(), $langCode);
        }
    }

    /**
     * Returns the language code in use.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return self::$translator->getLocale();
    }

    /**
     * Sets the language code in use.
     *
     * @param string $lang
     *
     * @return void
     */
    public function setlocale(string $lang): void
    {
        self::$translator->setLocale($lang);
    }

    /**
     * Returns an array with the languages with available translations.
     *
     * @return array
     */
    public function getAvailableLanguages(): array
    {
        $languages = [];
        $dir = $this->getBaseLangFolder();

        if (!is_dir($dir)) {
            \mkdir($dir, 0777, true);
        }
        $langFiles = Finder::create()
            ->files()
            ->name('*' . self::EXT)
            ->in($dir)
            ->sortByName();

        foreach ($langFiles as $langFile) {
            $langCode = str_replace(self::EXT, '', $langFile->getRelativePathName());
            $languages[$langCode] = $this->trans('language-' . $langCode);
        }
        return $languages;
    }

    /**
     * Stores if translation is used and if is missing.
     *
     * @param $lang
     */
    private function verifyMissing($lang)
    {
        self::$usedStrings[] = $lang;

        if ($this->getLocale() !== self::FALLBACK_LANG) {
            if (!self::$translator->getCatalogue()->has($lang)) {
                self::$missingStrings[] = $lang;
            }
        }
    }

    /**
     * Translate the text into the default language.
     *
     * @param null|string $txt
     * @param array       $parameters
     * @param             $domain
     * @param             $locale
     *
     * @return string
     */
    public function trans($txt, array $parameters = [], $domain = null, $locale = null): string
    {
        $lang = self::$translator->trans($txt, $parameters, $domain, $locale);
        $this->verifyMissing($lang);
        return $lang;
    }

    /**
     * Translate the text into the default language, but using choice.
     *
     * @param       $txt
     * @param       $number
     * @param array $parameters
     * @param       $domain
     * @param       $locale
     *
     * @return string
     */
    public function transChoice($txt, $number, array $parameters = [], $domain = null, $locale = null): string
    {
        $lang = self::$translator->transChoice($txt, $number, $parameters, $domain, $locale);
        $this->verifyMissing($lang);
        return $lang;
    }

    /**
     * Returns the missing strings.
     *
     * @return array
     */
    public function getMissingStrings(): array
    {
        return self::$missingStrings;
    }

    /**
     * Returns the strings used.
     *
     * @return array
     */
    public function getUsedStrings(): array
    {
        return self::$usedStrings;
    }

    /**
     * Returns the base lang folder.
     *
     * @return string
     */
    public function getBaseLangFolder(): string
    {
        return $this->basePath . self::LANG_FOLDER;
    }

    /**
     * Return the lang folders.
     *
     * @return array
     */
    public function getLangFolders(): array
    {
        $morePaths = [
            //BASE_PATH . '/config/languages',
        ];
        return array_merge(
            [$this->getBaseLangFolder()],
            $morePaths
        );
    }
}
