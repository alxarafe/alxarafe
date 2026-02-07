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
    /**
     * Returns the unique name of the collector
     *
     * @return string
     */
    #[\Override]
    public function getName(): string
    {
        return 'translations';
    }

    /**
     * Returns a hash where keys are control names and their values
     * an array of options as defined in {@see DebugBar\JavascriptRenderer::addControl()}
     *
     * @return array<string, array{default?: float|int|string, icon?: string, map?: string, title?: string, tooltip?: string, widget?: string}>
     */
    #[\Override]
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
     * @return array{base_path?: null|string, base_url?: null|string, css?: array<int|string, string>|string, inline_css?: array<int|string, string>, inline_head?: array<int|string, string>, inline_js?: array<int|string, string>, js?: array<int|string, string>|string}
     */
    #[\Override]
    public function getAssets(): array
    {
        return [
            'css' => constant('BASE_URL') . '/alxarafe/assets/DebugBar/Resources/translations.css',
            'js' => constant('BASE_URL') . '/alxarafe/assets/DebugBar/Resources/translations.js',
        ];
    }

    /**
     * Called by the DebugBar when data needs to be collected
     *
     * @return array Collected data
     */
    #[\Override]
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
