<?php

namespace Modules\Demo\Controller;

use Alxarafe\Base\Controller\ViewController;

class HomeController extends ViewController
{
    public static function getModuleName(): string
    {
        return 'Demo';
    }

    public static function getControllerName(): string
    {
        return 'Home';
    }

    public function doIndex(): bool
    {
        $this->title = 'Alxarafe Skeleton App';
        return true;
    }
}
