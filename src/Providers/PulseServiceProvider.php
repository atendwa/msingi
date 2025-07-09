<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Providers;

use Atendwa\Msingi\Contracts\InsightsUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Pulse\Facades\Pulse;

class PulseServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Pulse::user(fn (Model $model): array => array_merge($model->only(['email', 'name'], ['avatar' => null])));
    }

    protected function gate(): void
    {
        Gate::define('viewPulse', fn (InsightsUser $user): bool => $user->canViewInsight('viewPulse'));
    }
}
