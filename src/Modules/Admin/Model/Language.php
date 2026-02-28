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

namespace CoreModules\Admin\Model;

use Alxarafe\Base\Model\Model;

/**
 * @property string $code   ISO locale code (PK): 'es', 'en_GB', 'ca'
 * @property string $name   Native language name: 'Español', 'English'
 * @property string $flag   Flag-icons CSS code: 'es', 'gb', 'es-ct'
 * @property bool   $active Whether the language is available in the UI
 *
 * @method static find($code)
 * @method static where($column, $operator = null, $value = null)
 */
final class Language extends Model
{
    protected $table = 'languages';

    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['code', 'name', 'flag', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Scope: only active languages.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Extract the base language code from the locale.
     * 'ca_ES' → 'ca', 'es' → 'es'
     */
    public function getLanguageCode(): string
    {
        return explode('_', $this->code)[0];
    }

    /**
     * Extract the country code from the locale, if present.
     * 'ca_ES' → 'ES', 'es' → null
     */
    public function getCountryCode(): ?string
    {
        $parts = explode('_', $this->code);
        return $parts[1] ?? null;
    }

    /**
     * Get all active languages as [code => name] array.
     * Used as a drop-in replacement for Trans::getAvailableLanguages().
     */
    public static function getActiveList(): array
    {
        return static::active()
            ->orderBy('name')
            ->pluck('name', 'code')
            ->toArray();
    }

    /**
     * Get all active languages as [code => ['name' => ..., 'flag' => ...]] array.
     * Used by lang_switcher.blade.php.
     */
    public static function getActiveWithFlags(): array
    {
        return static::active()
            ->orderBy('name')
            ->get(['code', 'name', 'flag'])
            ->keyBy('code')
            ->toArray();
    }
}
