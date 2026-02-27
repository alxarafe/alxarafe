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

echo "--- Creating Admin User ---\n";
try {
    $user = User::where('name', 'user')->first();
    if ($user) {
        echo "User 'user' already exists.\n";
    } else {
        $user = new User();
        $user->name = 'user';
        $user->email = 'user@example.com';
        $user->password = password_hash('password', PASSWORD_DEFAULT);
        $user->is_admin = true;
        $user->save();
        echo "User 'user' created successfully with password 'password'.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
