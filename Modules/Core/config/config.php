<?php



return [
    'name' => 'Core',
    /*
     * Copyright (C) 2002-2007 Rodolphe Quiedeville <rodolphe@quiedeville.org>
     * Copyright (C) 2003      Xavier Dutoit        <doli@sydesy.com>
     * Copyright (C) 2004-2017 Laurent Destailleur  <eldy@users.sourceforge.net>
     * Copyright (C) 2004      Sebastien Di Cintio  <sdicintio@ressource-toi.org>
     * Copyright (C) 2004      Benoit Mortier       <benoit.mortier@opensides.be>
     * Copyright (C) 2005-2011 Regis Houssin        <regis.houssin@inodbox.com>
     * Copyright (C) 2005 	   Simon Tosser         <simon@kornog-computing.com>
     * Copyright (C) 2006 	   Andre Cianfarani     <andre.cianfarani@acdeveloppement.net>
     * Copyright (C) 2010      Juanjo Menent        <jmenent@2byte.es>
     * Copyright (C) 2015      Bahfir Abbes         <bafbes@gmail.com>
     * Copyright (c) 2024      Cayetano H. Osma     <chernandez@alxarafe.com>
     * Copyright (c) 2024      Rafael S. Tovar      <rsanjose@alxarafe.com>
     * Copyright (c) 2024      Francesc P. Segarra  <fpineda@alxarafe.com>
     * Copyright (c) 2024      Joshua D. Jobayna    <jrobayna@alxarafe.com>
     *
     * This program is free software; you can redistribute it and/or modify
     * it under the terms of the GNU General Public License as published by
     * the Free Software Foundation; either version 3 of the License, or
     * (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful,
     * but WITHOUT ANY WARRANTY; without even the implied warranty of
     * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     * GNU General Public License for more details.
     *
     * You should have received a copy of the GNU General Public License
     * along with this program. If not, see <https://www.gnu.org/licenses/>.
     */

    /*
    |--------------------------------------------------------------------------
    | General information about the application.
    |--------------------------------------------------------------------------
    |
    | General information for common tasks in the application code.
    |
    */
    'info' => [
        /*
        |--------------------------------------------------------------------------
        | Dolibarr application name.
        |--------------------------------------------------------------------------
        |
        | Application name, taken from .env
        |
        */
        'dol-application-title' => env('DOL_APPLICATION_TITLE', 'Dolibarr'),

        /*
        |--------------------------------------------------------------------------
        | Dolibarr base version
        |--------------------------------------------------------------------------
        |
        | Base version defined in the .env file.
        |
        */
        'dol-version' => ENV('DOL_VERSION', ''),

        /*
        |--------------------------------------------------------------------------
        | Euro currency character
        |--------------------------------------------------------------------------
        |
        | Set the Euro currency character.
        |
        */
        'euro' => '€',

        /*
        |--------------------------------------------------------------------------
        | Copyright information
        |--------------------------------------------------------------------------
        |
        | Copyright information to show in the console
        |
        */
        'copyright' => 'Copyright (c) 2020 El Estado Web Research & Development. All rights reserved.',

        /*
        |--------------------------------------------------------------------------
        | Application version
        |--------------------------------------------------------------------------
        |
        | Alxarafe version to show in the console
        |
        */
        'version' => ENV('APP_VERSION', '1.0'),

        /*
        |--------------------------------------------------------------------------
        | ${CARET}
        |--------------------------------------------------------------------------
        |
        | TO COMPLETE
        |
        */
        'version-message' => 'Version: %s - Subversion: %s',

        /*
        |--------------------------------------------------------------------------
        | ${CARET}
        |--------------------------------------------------------------------------
        |
        | TO COMPLETE
        |
        */
        'love-message' => 'Craft with ♥ in Spain',

        /*
        |--------------------------------------------------------------------------
        | Application version
        |--------------------------------------------------------------------------
        |
        | Alxarafe version to show in the console
        |
        */
        'subversion' => ENV('APP_SUBVERSION', '2024-Q1'),
    ],
    /*
    |--------------------------------------------------------------------------
    | Information related to i18n
    |--------------------------------------------------------------------------
    |
    | All configurations related to i18n
    |
    */
    'i18n' => [
        /*
        |--------------------------------------------------------------------------
        | Default Languages for App areas
        |--------------------------------------------------------------------------
        |
        | Defaulta languages for each application areas
        |
        */
        'default_locale' => [
            /*
            |--------------------------------------------------------------------------
            | Default Console Language
            |--------------------------------------------------------------------------
            |
            | Default Console Language as American English
            |
            */
            'default_console_locale' => 'en_US',
        ],
    ],
    'filesystem' => [
        /*
        |--------------------------------------------------------------------------
        | Dolibarr root document folder
        |--------------------------------------------------------------------------
        |
        | Folder where the document root is point to
        |
        */
        'dol-main-document-root' => env(
            'DOLIBARR_MAIN_DOCUMENT_ROOT',
            public_path().DIRECTORY_SEPARATOR.'htdocs'
        ),

        /*
        |--------------------------------------------------------------------------
        | Folder where Documents will be uploaded
        |--------------------------------------------------------------------------
        |
        | This folder point to the folder where documents will be uploaded.
        | in the future, we need to use a folder in the Laravel Filesystem to protect undesired accesses
        |
        */
        'dol-main-data-root' => env(
            'DOLIBARR_MAIN_DATA_ROOT',
            public_path().DIRECTORY_SEPARATOR.'htdocs'.DIRECTORY_SEPARATOR.'documents'
        ),

        // 'dol-core-modules-root' => env('')
    ],
];
