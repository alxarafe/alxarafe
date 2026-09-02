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

namespace Modules\Admin\Service;

use Alxarafe\Infrastructure\Persistence\Config;

/**
 * Demo mode controls the behaviour of the application when a "demo"
 * section exists in config.json.
 *
 * The section is administrator-managed only and is never editable from the app.
 * When absent or disabled, everything behaves as normal and nothing is shown.
 * Example:
 *   "demo": { "enabled": true, "readonly_config": true, "protect_user_changes": true }
 */
class DemoMode
{
    private static function demo(): ?object
    {
        try {
            return Config::getConfig()?->demo ?? null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function isEnabled(): bool
    {
        return (bool)(self::demo()?->enabled ?? false);
    }

    public static function isReadonlyConfig(): bool
    {
        if (!self::isEnabled()) {
            return false;
        }
        return (bool)(self::demo()?->readonly_config ?? false);
    }

    public static function protectsUserChanges(): bool
    {
        if (!self::isEnabled()) {
            return false;
        }
        return (bool)(self::demo()?->protect_user_changes ?? false);
    }
}
