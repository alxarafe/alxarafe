<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Alxarafe\Base\Config;
use Alxarafe\Base\Database;
use Illuminate\Database\Capsule\Manager as Capsule;

abstract class TestCase extends BaseTestCase
{
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure Database Connection
        $config = Config::getConfig();
        if ($config && isset($config->db)) {
            // Re-use connection or create if not exists
            try {
                Capsule::connection();
            } catch (\Throwable $e) {
                Database::createConnection($config->db);
            }
        }

        // Begin Transaction
        Capsule::connection()->beginTransaction();
    }

    #[\Override]
    protected function tearDown(): void
    {
        // Rollback Transaction
        Capsule::connection()->rollBack();

        // Reset Auth User
        \Alxarafe\Lib\Auth::$user = null;

        parent::tearDown();
    }
}
