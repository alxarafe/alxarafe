<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Providers;

use Alxarafe\Core\Helpers\Utils\FileSystemUtils;
use Alxarafe\Core\Models\Module;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\Translator as SymfonyTranslator;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Lang, give support to internationalization.
 *
 * @package Alxarafe\Core\Providers
 */
class Translator
{
    use Singleton {
        getInstance as getInstanceTrait;
    }

    /**
     * Default language to use if language file not exists.
     */
    public const FALLBACK_LANG = 'en';

    /**
     * Base folder where languages files are stored.
     */
    public const LANG_FOLDER = DIRECTORY_SEPARATOR . 'Languages';

    /**
     * Default language to use.
     */
    public const LANG = 'es_ES';

    /**
     * Extension of language file.
     */
    public const EXT = '.yaml';

    /**
     * Format of language file.
     */
    public const FORMAT = 'yaml';

    /**
     * The Symfony translator.
     *
     * @var SymfonyTranslator
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
     * @var string
     */
    private static $languageFolder;

    /**
     * Lang constructor.
     */
    public function __construct()
    {
        if (!isset(self::$translator)) {
            $this->initSingleton();
            $config = $this->getConfig();
            self::$languageFolder = constant('ALXARAFE_FOLDER') . self::LANG_FOLDER;
            self::$translator = new SymfonyTranslator($config['language'] ?? self::FALLBACK_LANG);
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
    public function loadLangFiles(): void
    {
        $langFiles = Finder::create()
            ->files()
            ->name('*' . self::EXT)
            ->in($this->getLangFolders())
            ->sortByName();
        foreach ($langFiles as $langFile) {
            $langCode = str_replace(self::EXT, '', $langFile->getRelativePathName());
            try {
                Yaml::parseFile($langFile->getPathName());
                self::$translator->addResource(self::FORMAT, $langFile->getPathName(), $langCode);
            } catch (ParseException $e) {
                Logger::getInstance()::exceptionHandler($e);
            }
        }
    }

    /**
     * Return the lang folders.
     *
     * @return array
     */
    public function getLangFolders(): array
    {
        $morePaths = [];

        // Can be better add a method "addLangFolders/setLangFolders" to set this from outside when was needed?
        // This introduce class dependency
        if (Database::getInstance()->getDbEngine()->checkConnection()) {
            $modules = (new Module())->getEnabledModules();
            foreach (array_reverse($modules) as $module) {
                $morePaths[] = basePath($module->path);
            }
        }

        return array_merge(
            [$this->getBaseLangFolder()],
            $morePaths
        );
    }

    /**
     * Returns the base lang folder.
     *
     * @return string
     */
    public function getBaseLangFolder(): string
    {
        return self::$languageFolder;
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
        return ['language' => self::FALLBACK_LANG];
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
        FileSystemUtils::mkdir($dir, 0777, true);
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
        $this->verifyMissing($txt, $lang);
        return $lang;
    }

    /**
     * Stores if translation is used and if is missing.
     *
     * @param string $reference
     * @param string $translation
     */
    private function verifyMissing($reference, $translation): void
    {
        self::$usedStrings[] = $reference;

        if ($this->getLocale() !== self::FALLBACK_LANG) {
            // Is missing for the language configured?
//            if (!self::$translator->getCatalogue($this->getLocale())->has($reference)) {
//                self::$missingStrings[$reference] = $translation;
//            }
            // Is missing on full catalogue?
            if (!self::$translator->getCatalogue()->has($reference)) {
                self::$missingStrings[$reference] = $translation;
            }
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
     * Returns the original translator.
     *
     * @return SymfonyTranslator
     */
    public function getTranslator(): SymfonyTranslator
    {
        return self::$translator;
    }
}
