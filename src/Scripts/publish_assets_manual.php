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

echo "Alxarafe Asset Publication Script v1.1" . PHP_EOL;

// Robust autoloader discovery
$autoloaders = [
    __DIR__ . '/../../vendor/autoload.php',           // Standard root
    __DIR__ . '/../../skeleton/vendor/autoload.php',  // Skeleton-first (CI)
    __DIR__ . '/../../../../autoload.php',            // vendor/alxarafe/alxarafe/src/Scripts
];

$loaded = false;
foreach ($autoloaders as $autoloader) {
    if (file_exists($autoloader)) {
        echo "Loading autoloader: " . realpath($autoloader) . PHP_EOL;
        require $autoloader;
        $loaded = true;
        break;
    }
}

if (!$loaded) {
    echo "Fatal error: Could not find vendor/autoload.php in any of the expected locations." . PHP_EOL;
    foreach ($autoloaders as $path) {
        echo "  Checked: " . realpath($path) . " (" . $path . ")" . PHP_EOL;
    }
    exit(1);
}

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
