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

class Image extends AbstractField
{
    protected string $component = 'image';

    /**
     * @param string $src URL of the image
     * @param string $alt Alt text
     * @param array $options Additional options (width, height, class)
     */
    public function __construct(string $src, string $alt = '', array $options = [])
    {
        parent::__construct('img_' . md5($src), $alt, array_merge(['src' => $src], $options));
    }

    #[\Override]
    public function getType(): string
    {
        return 'image';
    }
}
