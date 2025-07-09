<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Providers;

use Atendwa\Msingi\Contracts\InsightsUser;
use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    public function register(): void
    {
        Telescope::night();

        $this->hideSensitiveRequestDetails();

        Telescope::filter(fn (IncomingEntry $incomingEntry): bool => boolval(any([
            $incomingEntry->isScheduledTask(), $incomingEntry->hasMonitoredTag(),
            $incomingEntry->isFailedRequest(), $incomingEntry->isFailedJob(),
            app()->isLocal(), $incomingEntry->isReportableException(),
        ])));
    }

    protected function hideSensitiveRequestDetails(): void
    {
        if (app()->isLocal()) {
            return;
        }

        Telescope::hideRequestHeaders(['cookie', 'x-csrf-token', 'x-xsrf-token']);
        Telescope::hideRequestParameters(['_token']);
    }

    protected function gate(): void
    {
        Gate::define('viewTelescope', fn (InsightsUser $user): bool => $user->canViewInsight('viewTelescope'));
    }
}
