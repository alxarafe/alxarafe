<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\PreProcessors;

use Alxarafe\Core\Helpers\Utils\FileSystemUtils;
use Alxarafe\Core\Models\Language;
use Alxarafe\Core\Providers\DebugTool;
use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Providers\Logger;
use Symfony\Component\Yaml\Exception\ParseException;
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
    public static function exportLanguages(): void
    {
        $debugTool = DebugTool::getInstance();

        $subfolder = 'Languages';
        $sourceFolders = [
            constant('ALXARAFE_FOLDER') . constant('DIRECTORY_SEPARATOR') . $subfolder,
            basePath($subfolder),
        ];

        $destinationFolder = basePath('config' . DIRECTORY_SEPARATOR . 'languages');
        FileSystemUtils::mkdir($destinationFolder, 0777, true);

        $languages = (new Language())->getAllRecords();
        if (count($languages) === 0) {
            return;
        }

        $defaultFileName = $languages[0]['language'];
        foreach ($languages as $lang) {
            if (!isset($lang['variant'])) {
                $lang['variant'] = strtoupper($lang['language']);
            }

            $fileName = $lang['language'] . '_' . $lang['variant'];
            $debugTool->addMessage('messages', 'Processing ' . $fileName . ' language');

            $subLanguage = null;
            if ($lang['variant'] !== strtoupper($lang['language'])) {
                $subLanguage = $lang['language'] . '_' . strtoupper($lang['language']);
            }

            $allData = [];
            foreach ($sourceFolders as $source) {
                $data = [[]];

                // Se carga el array más general o por defecto (p.e. en inglés)
                $default = $source . DIRECTORY_SEPARATOR . $defaultFileName . '.yaml';
                if (file_exists($default)) {
                    try {
                        $data[] = Yaml::parseFile($default);
                    } catch (ParseException $e) {
                        Logger::getInstance()::exceptionHandler($e);
                        FlashMessages::getInstance()::setError($e->getFile() . ' ' . $e->getLine() . ' ' . $e->getMessage());
                        $data = [];
                    }
                }

                // Si es un idioma dependiente, se intenta cargar el genérico
                // Así por ejemplo, para es_AR se cargaría el es_ES que será mejor que el en_EN
                if (isset($subLanguage)) {
                    $file = $source . DIRECTORY_SEPARATOR . $subLanguage . '.yaml';
                    if (file_exists($file)) {
                        try {
                            $data[] = Yaml::parseFile($file);
                        } catch (ParseException $e) {
                            Logger::getInstance()::exceptionHandler($e);
                            FlashMessages::getInstance()::setError($e->getFile() . ' ' . $e->getLine() . ' ' . $e->getMessage());
                            $data = [];
                        }
                    }
                }

                // Ya por último, se carga el idioma que hemos solicitado, p.e. es_AR
                $file = $source . DIRECTORY_SEPARATOR . $fileName . '.yaml';
                if (file_exists($file)) {
                    try {
                        $data[] = Yaml::parseFile($file);
                    } catch (ParseException $e) {
                        Logger::getInstance()::exceptionHandler($e);
                        FlashMessages::getInstance()::setError($e->getFile() . ' ' . $e->getLine() . ' ' . $e->getMessage());
                        $data = [];
                    }
                }

                $allData = array_merge(...$data);
            }
            ksort($allData);
            $file = $destinationFolder . DIRECTORY_SEPARATOR . $fileName . '.yaml';
            $result = file_put_contents($file, Yaml::dump($allData));
            if ($result) {
                FlashMessages::getInstance()::setInfo('You can download the file from: ' . $file);
            }
        }
    }
}
