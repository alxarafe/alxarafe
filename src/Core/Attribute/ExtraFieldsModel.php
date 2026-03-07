<?php

declare(strict_types=1);

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

namespace Alxarafe\Attribute;

use Attribute;

/**
 * Attribute to explicitly define the ExtraFields model for a Resource.
 * 
 * Usage:
 * #[ExtraFieldsModel(MyModelExtraFields::class)]
 */
#[Attribute(Attribute::TARGET_CLASS)]
class ExtraFieldsModel
{
    public function __construct(
        public string $modelClass,
        public string $suffix = 'ExtraFields',
        public string $prefix = 'extra_fields_',
        public string $label = 'extra_fields'
    ) {
}
}
