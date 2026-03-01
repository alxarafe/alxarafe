<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Modules\Agenda\Seeders\AgendaSeeder;
use Alxarafe\Base\Config;

if (!defined('BASE_PATH')) define('BASE_PATH', __DIR__ . '/../skeleton/public');
if (!defined('APP_PATH')) define('APP_PATH', __DIR__ . '/../skeleton');
if (!defined('ALX_PATH')) define('ALX_PATH', __DIR__ . '/..');

$config = Config::getConfig();
\Alxarafe\Base\Database::createConnection($config->db);

// Disable FK checks to allow truncate
\Illuminate\Database\Capsule\Manager::schema()->disableForeignKeyConstraints();

new AgendaSeeder(true);

\Illuminate\Database\Capsule\Manager::schema()->enableForeignKeyConstraints();

echo "Seeding completed.\n";
