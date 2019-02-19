<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\Controller;
use Alxarafe\Base\View;
use Alxarafe\Models\Language;
use Alxarafe\Providers\DebugTool;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Languages
 *
 * @package Alxarafe\Controllers
 */
class Languages extends Controller
{

    /**
     * Languages constructor.
     */
    public function __construct()
    {
        parent::__construct(new Language());
        $this->main();
    }

    /**
     * Main is invoked if method is not specified. Check if you have to save changes or just exit.
     *
     * @return void
     */
    public function main(): void
    {
        $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_ENCODED);
        switch ($action) {
            case 'regenerate':
                $this->regenerate();
                break;
        }
    }

    public function regenerate()
    {
        $subfolder = '/Languages';
        $sourceFolders = [
            constant('ALXARAFE_FOLDER') . $subfolder,
            constant('BASE_PATH') . $subfolder,
        ];

        $destinationFolder = constant('BASE_PATH') . '/config/languages';
        if (!is_dir($destinationFolder)) {
            \mkdir($destinationFolder, 0777, true);
        }

        $languages = $this->model->getAllRecords();
        if (count($languages) == 0) {
            return;
        }

        $default_lang = $languages[0]['language'];
        $default_variant = $languages[0]['variant'];
        if (!isset($default_variant)) {
            $default_variant = strtoupper($default_lang);
        }

        $defaultFileName = $default_lang . '_' . $default_variant;
        foreach ($languages as $lang) {
            if (!isset($lang['variant'])) {
                $lang['variant'] = strtoupper($lang['language']);
            }

            $fileName = $lang['language'] . '_' . $lang['variant'];
            DebugTool::getInstance()->addMessage('messages', 'Processing ' . $fileName . ' language');
            // echo '<p>Processing ' . $lang['language'] . '_' . $lang['variant'] . ' language</p>';

            $subLanguage = null;
            if ($lang['variant'] != strtoupper($lang['language'])) {
                $subLanguage = $lang['language'] . '_' . strtoupper($lang['language']);
            }

            $allData = [];
            foreach ($sourceFolders as $source) {
                $data = [];

                // Se carga el array más general o por defecto (p.e. en inglés)
                $default = $source . '/' . $defaultFileName . '.yaml';
                // echo '<p>Processing ' . $default . '</p>';
                if (file_exists($default)) {
                    $data = Yaml::parse(file_get_contents($default));
                }

                // Si es un idioma dependiente, se intenta cargar el genérico
                // Así por ejemplo, para es_AR se cargaría el es_ES que será mejor que el en_EN
                if (isset($subLanguage)) {
                    $file = $source . '/' . $subLanguage . '.yaml';
                    // echo '<p>Processing ' . $file . '</p>';
                    if (file_exists($file)) {
                        $data = array_merge($data, Yaml::parse(file_get_contents($file)));
                    }
                }

                // Ya por último, se carga el idioma que hemos solicitado, p.e. es_AR
                $file = $source . '/' . $fileName . '.yaml';
                // echo '<p>Processing ' . $file . '</p>';
                if (file_exists($file)) {
                    $data = array_merge($data, Yaml::parse(file_get_contents($file)));
                }

                $allData = array_merge($allData, $data);
            }
            ksort($allData);
            file_put_contents($destinationFolder . '/' . $fileName . '.yaml', Yaml::dump($allData));
        }
    }

    public function getNewButtons()
    {
        $return = [];
        $return[] = [
            'link' => $this->url . '&action=regenerate',
            'icon' => 'glyphicon-refresh',
            'text' => 'regenerate-data',
            'type' => 'info',
        ];
        return $return;
    }

    /**
     * The start point of the controller.
     *
     * @return void
     */
    public function run(): void
    {
        $this->setView(new View($this));
        parent::run();
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'controller-languages-title',
            'icon' => '<span class="glyphicon glyphicon-globe" aria-hidden="true"></span>',
            'description' => 'controller-languages-description',
            'menu' => 'regional-info',
        ];
        return $details;
    }
}
