<?php

namespace Alxarafe\Tools\DebugBarCollector;

use Alxarafe\Lib\Trans;
use DebugBar\DataCollector\AssetProvider;
use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use Symfony\Component\Translation\Translator;

class TranslatorCollector extends DataCollector implements Renderable, AssetProvider
{
    /**
     * Array containing the translations
     *
     * @var array
     */
    protected array $translations;

    /**
     * TranslationCollector constructor.
     *
     * @param Translator $translator
     */
    public function __construct()
    {
        $this->translations = [];
    }

    /**
     * Returns the unique name of the collector
     *
     * @return string
     */
    public function getName(): string
    {
        return 'translations';
    }

    /**
     * Returns a hash where keys are control names and their values
     * an array of options as defined in {@see DebugBar\JavascriptRenderer::addControl()}
     *
     * @return array
     */
    public function getWidgets(): array
    {
        return [
            'translations' => [
                'icon' => 'language',
                'tooltip' => 'Translations',
                'widget' => 'PhpDebugBar.Widgets.TranslationsWidget',
                'map' => 'translations',
                'default' => '[]',
            ],
            'translations:badge' => [
                'map' => 'translations.nb_statements',
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
            'css' => constant('BASE_URL') . '/alxarafe/assets/debugbar/translations.css',
            'js' => constant('BASE_URL') . '/alxarafe/assets/debugbar/translations.js',
        ];
    }

    /**
     * Called by the DebugBar when data needs to be collected
     *
     * @return array Collected data
     */
    public function collect(): array
    {
        $this->addTranslations();

        return [
            'nb_statements' => count($this->translations),
            'translations' => $this->translations,
        ];
    }

    /**
     * Add a translation key to the collector
     */
    private function addTranslations()
    {
        foreach (Trans::getMissingStrings() as $key => $value) {
            $this->translations[] = [
                'key' => $key,
                'value' => $value,
            ];
        }
    }
}
