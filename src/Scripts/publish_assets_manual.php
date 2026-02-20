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

namespace Alxarafe\Scripts;

require __DIR__ . '/../../vendor/autoload.php';

class MockIO
{
    public function write($msg)
    {
        echo $msg . PHP_EOL;
    }
    public function getIO()
    {
        return $this;
    }
}


// Our MockIO can act as both the event and the IO for simplicity here if we tweak postUpdate slightly
// or we can wrap it. Let's wrap it properly.

class MockEvent
{
    private $io;
    public function __construct()
    {
        $this->io = new MockIO();
    }
    public function getIO()
    {
        return $this->io;
    }
}

echo "Manual Asset Publication Triggered..." . PHP_EOL;

if (class_exists(ComposerScripts::class)) {
    ComposerScripts::postUpdate(new MockEvent());
} else {
    echo "ComposerScripts class not found." . PHP_EOL;
    exit(1);
}
