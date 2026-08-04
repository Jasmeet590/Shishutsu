<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $testDatabasePath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testDatabasePath = storage_path('framework/testing.sqlite');
        if (!file_exists($this->testDatabasePath)) {
            touch($this->testDatabasePath);
        }

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => $this->testDatabasePath,
        ]);

        $this->artisan('migrate:fresh');
    }

    protected function tearDown(): void
    {
        if ($this->testDatabasePath && file_exists($this->testDatabasePath)) {
            @unlink($this->testDatabasePath);
        }

        parent::tearDown();
    }
}
