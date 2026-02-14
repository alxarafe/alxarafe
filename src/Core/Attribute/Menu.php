<?php

namespace Alxarafe\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Menu
{
    public function __construct(
        public string  $menu,
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $route = null,
        public ?string $url = null,
        public ?string $parent = null,
        public int     $order = 99,
        public ?string $permission = null,
        public string  $visibility = 'auth', // 'auth', 'guest', 'public'
        public ?string $badgeResolver = null,
        public ?string $badgeClass = null,
        public ?string $class = null
    ) {
}
}
