<?php
define('APP_PATH', realpath(__DIR__ . '/..')); define('ALX_PATH', realpath(__DIR__ . '/../..')); define('BASE_PATH', APP_PATH . '/public');
require_once APP_PATH . '/vendor/autoload.php';

use Alxarafe\Base\Config;
use Alxarafe\Base\Database;
use CoreModules\Admin\Model\User;

$config = Config::getConfig();
if ($config && isset($config->db)) {
    Database::createConnection($config->db);
}

echo "--- Users in DB ---\n";
try {
    $users = User::all();
    if ($users->isEmpty()) {
        echo "No users found.\n";
    } else {
        foreach ($users as $user) {
            echo "ID: " . $user->id . ", Name: " . $user->name . ", Email: " . $user->email . "\n";
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
