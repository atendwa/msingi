<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Providers;

use Atendwa\Msingi\Contracts\InsightsUser;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    public function boot(): void {}

    protected function gate(): void
    {
        Gate::define('viewHorizon', fn (InsightsUser $user): bool => $user->canViewInsight('viewHorizon'));
    }
}
