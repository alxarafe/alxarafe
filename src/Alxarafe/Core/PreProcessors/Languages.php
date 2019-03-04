<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\PreProcessors;

use Alxarafe\Core\Models\Language;
use Alxarafe\Core\Providers\DebugTool;
use Symfony\Component\Yaml\Yaml;

/**
 * This class pre-process pages to generate some needed information.
 *
 * @package Alxarafe\Core\PreProcessors
 */
class Languages
{
    /**
     * The best way to get the list is still to be determined, as well as if
     * domains are going to be used.
     *
     * You have to see the best format for debugging the texts. Yaml or CSV?,
     * All or classified by modules or domains?
     *
     *         translator->getTranslator()->getCatalogue());
     *
     * TODO: This must be moved to ProProcessors namespace
     */
    public static function exportLanguages()
    {
        $debugTool = DebugTool::getInstance();

        $subfolder = 'Languages';
        $sourceFolders = [
            constant('ALXARAFE_FOLDER') . constant('DIRECTORY_SEPARATOR') . $subfolder,
            basePath($subfolder),
        ];

        $destinationFolder = basePath('config/languages');
        if (!is_dir($destinationFolder)) {
            \mkdir($destinationFolder, 0777, true);
        }

        $languages = (new Language())->getAllRecords();
        if (count($languages) == 0) {
            return;
        }

        /*
          $default_lang = $languages[0]['language'];
          $default_variant = $languages[0]['variant'];
          if (!isset($default_variant)) {
          $default_variant = strtoupper($default_lang);
          }

          $defaultFileName = $default_lang . '_' . $default_variant;
         */
        $defaultFileName = $languages[0]['language'];
        foreach ($languages as $lang) {
            if (!isset($lang['variant'])) {
                $lang['variant'] = strtoupper($lang['language']);
            }

            $fileName = $lang['language'] . '_' . $lang['variant'];
            $debugTool->addMessage('messages', 'Processing ' . $fileName . ' language');
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
}
