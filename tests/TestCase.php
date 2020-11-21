<?php

namespace Tests;

use Orchestra\Testbench\Concerns\WithLoadMigrationsFrom;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithLoadMigrationsFrom;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }
    protected function getPackageProviders($app)
    {
        parent::getPackageProviders($app);

        return [
            'Fguzman\QueryFilterServiceProvider'
        ];
    }
    public function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set([
            'database.default' => 'querydb',
        ]);

        $app['config']->set('database.connections.querydb', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);
    }
}
