<?php

declare(strict_types=1);

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
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
 * Class Setting.
 * Generic key-value settings storage.
 *
 * Used for module activation state, SMTP configuration,
 * and any other runtime configuration needs.
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 */
class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get a setting value by key.
     *
     * @param string $key     Setting key
     * @param mixed  $default Default value if not found
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value by key (create or update).
     *
     * @param string $key   Setting key
     * @param mixed  $value Setting value
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => (string) $value]
        );
    }

    /**
     * Check if a setting key exists.
     */
    public static function has(string $key): bool
    {
        return static::where('key', $key)->exists();
    }

    /**
     * Get a boolean setting value.
     */
    public static function getBool(string $key, bool $default = false): bool
    {
        $value = static::get($key);
        if ($value === null) {
            return $default;
        }
        return in_array($value, ['1', 'true', 'yes'], true);
    }
}
