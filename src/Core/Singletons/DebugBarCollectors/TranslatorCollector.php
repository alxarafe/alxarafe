<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Singletons\DebugBarCollectors;

use Alxarafe\Core\Singletons\Translator;
use DebugBar\DataCollector\AssetProvider;
use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;

/**
 * This class collects the translations
 *
 * @source Based on: https://github.com/spiroski/laravel-debugbar-translations
 */
class TranslatorCollector extends DataCollector implements Renderable, AssetProvider
{
    /**
     * Nombre de la pestaña
     *
     * @var string
     */
    private static string $name;

    /**
     * Array containing the translations
     *
     * @var array
     */
    private static array $translations;

    /**
     * TranslationCollector constructor.
     */
    public function __construct(string $name = 'translations')
    {
        self::$name = $name;
        self::$translations = [];
    }

    /**
     * Returns the unique name of the collector
     *
     * @return string
     */
    public function getName(): string
    {
        return self::$name;
    }

    /**
     * Returns a hash where keys are control names and their values
     * an array of options as defined in {@see DebugBar\JavascriptRenderer::addControl()}
     *
     * @return array
     */
    public function getWidgets(): array
    {
        $name = self::$name;
        return [
            $name => [
                'icon' => 'language',
                                'tooltip' => 'Translations',
                'widget' => 'PhpDebugBar.Widgets.TranslationsWidget',
                'map' => "translations",
                'default' => '[]',
            ],
            "$name:badge" => [
                'map' => "$name.nb_statements",
                'default' => 0,
            ],
        ];
    }

    /**
     * Returns the needed assets
     *
     * @return array
     */
    public function getAssets(): array
    {
        return [
            'css' => BASE_URI . '/html/common/css/phpdebugbar.custom-widget.css',
            'js' => BASE_URI . '/html/common/js/phpdebugbar.custom-widget.js',
        ];
    }

    /**
     * Called by the DebugBar when data needs to be collected
     *
     * @return array Collected data
     */
    public function collect(): array
    {
        self::addTranslations();
        return [
            'nb_statements' => count(self::$translations),
            'translations' => self::$translations,
        ];
    }

    /**
     * Add a translation key to the collector
     */
    private static function addTranslations()
    {
        foreach (Translator::getMissingStrings() as $key => $value) {
            self::$translations[] = [
                'key' => $key,
                'value' => $value,
//                'message' => 'Not found ' . $key . ' for local language. Used ' . $value,
            ];
        }
    }
}
