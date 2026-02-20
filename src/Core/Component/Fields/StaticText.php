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

namespace Alxarafe\Component\Fields;

use Alxarafe\Component\AbstractField;

/**
 * Class StaticText
 * Renders a static text block (HTML allowed) instead of an input field.
 */
class StaticText extends AbstractField
{
    protected string $component = 'static_text';

    public function __construct(string $content, array $options = [])
    {
        // Field name is irrelevant for static text, use hash
        parent::__construct('static_' . md5($content), $content, $options);
    }

    #[\Override]
    public function getType(): string
    {
        return 'static_text';
    }
}
