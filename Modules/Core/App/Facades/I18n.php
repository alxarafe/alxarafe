<?php



namespace Modules\Core\App\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Core\App\Classes\Internacionalization;

class I18n extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Internacionalization::class;
    }
}
