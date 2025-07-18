<?php

namespace Atendwa\Msingi\Tests;

use Atendwa\Msingi\MsingiServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
    }

    protected function getPackageProviders($app): array
    {
        return [
            MsingiServiceProvider::class,
        ];
    }
}
