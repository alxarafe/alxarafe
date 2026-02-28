<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        Capsule::schema()->create('languages', function (Blueprint $table) {
            $table->string('code', 5)->primary();
            $table->string('name', 50);
            $table->string('flag', 5);
            $table->boolean('active')->default(false);
            $table->timestamps();
        });

        // Seed: all languages in idioma_PAIS format
        // Trans::loadLang() handles fallback: 'es_ES' loads es.yaml, then es_ES.yaml if exists
        $languages = [
            // Active by default
            ['code' => 'en_US', 'name' => 'English (US)',         'flag' => 'us',    'active' => true],
            ['code' => 'en_GB', 'name' => 'English (UK)',         'flag' => 'gb',    'active' => true],
            ['code' => 'es_ES', 'name' => 'Español',              'flag' => 'es',    'active' => true],
            ['code' => 'fr_FR', 'name' => 'Français',             'flag' => 'fr',    'active' => true],
            ['code' => 'de_DE', 'name' => 'Deutsch',              'flag' => 'de',    'active' => true],
            ['code' => 'pt_PT', 'name' => 'Português',            'flag' => 'pt',    'active' => true],
            ['code' => 'it_IT', 'name' => 'Italiano',             'flag' => 'it',    'active' => true],
            ['code' => 'ca_ES', 'name' => 'Català',               'flag' => 'es-ct', 'active' => true],
            // Inactive by default
            ['code' => 'ar_SA', 'name' => 'العربية',              'flag' => 'sa',    'active' => false],
            ['code' => 'eu_ES', 'name' => 'Euskara',              'flag' => 'es-pv', 'active' => false],
            ['code' => 'gl_ES', 'name' => 'Galego',               'flag' => 'es-ga', 'active' => false],
            ['code' => 'hi_IN', 'name' => 'हिन्दी',                 'flag' => 'in',    'active' => false],
            ['code' => 'ja_JP', 'name' => '日本語',                'flag' => 'jp',    'active' => false],
            ['code' => 'nl_NL', 'name' => 'Nederlands',           'flag' => 'nl',    'active' => false],
            ['code' => 'ru_RU', 'name' => 'Русский',              'flag' => 'ru',    'active' => false],
            ['code' => 'zh_CN', 'name' => '中文',                  'flag' => 'cn',    'active' => false],
            ['code' => 'es_AR', 'name' => 'Español (Argentina)',  'flag' => 'ar',    'active' => false],
            ['code' => 'pt_BR', 'name' => 'Português (Brasil)',   'flag' => 'br',    'active' => false],
        ];

        $now = date('Y-m-d H:i:s');
        foreach ($languages as $lang) {
            Capsule::table('languages')->insert(array_merge($lang, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('languages');
    }
};
