<?php

namespace Atendwa\Msingi;

use Atendwa\Msingi\Commands\CheckHorizonStatus;
use Atendwa\Msingi\Commands\InstallMsingi;
use Atendwa\Msingi\Providers\HorizonServiceProvider;
use Atendwa\Msingi\Providers\MacroServiceProvider;
use Atendwa\Msingi\Providers\PulseServiceProvider;
use Atendwa\Msingi\Providers\TelescopeServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Throwable;

class MsingiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/msingi.php', 'msingi');

        $this->app->register(TelescopeServiceProvider::class);
        $this->app->register(HorizonServiceProvider::class);
        $this->app->register(PulseServiceProvider::class);
        $this->app->register(MacroServiceProvider::class);
    }

    /**
     * @throws Throwable
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes/console.php');

        $this->commands([CheckHorizonStatus::class]);

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/msingi.php' => config_path('msingi.php')], 'config');
            $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], 'migrations');
            $this->publishes([__DIR__ . '/../resources/views' => resource_path('views/vendor')], 'views');
            $this->publishes([__DIR__ . '/../assets' => base_path()], 'assets');

            $this->commands([InstallMsingi::class]);
        }

        DB::prohibitDestructiveCommands($this->app->isProduction());
        Model::shouldBeStrict();
    }
}
