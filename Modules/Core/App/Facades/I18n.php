<?php

declare(strict_types=1);

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
