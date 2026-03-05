<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);

namespace Alxarafe\Attribute;

use Attribute;

/**
 * Attribute to declare cosmetic metadata for a module.
 *
 * Place this on a class inside `Module.php` at the root of each module directory.
 * Dependencies are auto-detected by DependencyResolver scanning `use` statements;
 * this attribute only provides display information.
 *
 * Example:
 * ```php
 * #[ModuleInfo(name: 'CRM', description: 'Customer Relationship Management', icon: 'fas fa-id-card')]
 * class Module {}
 * ```
 *
 * @see \Alxarafe\Tools\DependencyResolver
 */
#[Attribute(Attribute::TARGET_CLASS)]
class ModuleInfo
{
    public function __construct(
        /** Human-readable module name */
        public string $name,
        /** Short description of what the module does */
        public string $description = '',
        /** FontAwesome icon class */
        public string $icon = 'fas fa-puzzle-piece',
        /** FQCN of the module's configuration controller, if any */
        public ?string $setupController = null,
        /** If true, this module is always enabled and cannot be toggled off */
        public bool $core = false,
    ) {}
}
