<?php

namespace Alxarafe\Base;

use Illuminate\Container\Container;

class BladeContainer extends Container
{
    /**
     * Mock terminating method required by Illuminate\View\ViewServiceProvider
     * but missing in the base Container.
     * 
     * @param mixed $callback
     * @return void
     */
    public function terminating($callback)
    {
        // No-op for standalone Blade usage
    }
}
