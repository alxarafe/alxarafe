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

namespace Alxarafe\Infrastructure\Service;

/**
 * Standard hook point names for the framework.
 * Use HookService::resolve() to replace placeholders.
 *
 * Example: HookService::resolve(HookPoints::FORM_FIELDS_AFTER, ['entity' => 'ThirdParty'])
 *          → 'form.ThirdParty.fields.after'
 */
class HookPoints
{
    // Form hooks
    public const FORM_FIELDS_BEFORE = 'form.{entity}.fields.before';
    public const FORM_FIELDS_AFTER  = 'form.{entity}.fields.after';
    public const FORM_TAB_CONTENT   = 'form.{entity}.tab.{tab}';

    // List hooks
    public const LIST_COLUMNS       = 'list.{entity}.columns';
    public const LIST_ROW_ACTIONS   = 'list.{entity}.row_actions';

    // Action hooks
    public const BEFORE_SAVE   = 'action.{entity}.before_save';
    public const AFTER_SAVE    = 'action.{entity}.after_save';
    public const BEFORE_DELETE = 'action.{entity}.before_delete';
    public const AFTER_DELETE  = 'action.{entity}.after_delete';
}
