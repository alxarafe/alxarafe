<?php

require __DIR__ . '/../vendor/autoload.php';

// Cargar alias y autoloader de emergencia (similar a index.php)
if (file_exists(__DIR__ . '/../src/Infrastructure/Legacy/aliases.php')) {
    require_once __DIR__ . '/../src/Infrastructure/Legacy/aliases.php';
}

Tests\Bootstrapper::boot();
