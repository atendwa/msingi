<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Widgets;

use Atendwa\Msingi\Filament\Pages\HorizonPage;
use Atendwa\Msingi\Filament\Pages\PulsePage;
use Atendwa\Msingi\Filament\Pages\TelescopePage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Artisan;

class InsightsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected static bool $isLazy = false;

    protected function getColumns(): int
    {
        return count($this->getStats());
    }

    protected function getStats(): array
    {
        $telescope = config('telescope.enabled');
        $pulse = config('pulse.enabled');

        Artisan::call('horizon:check-status');
        $status = asString(session('horizon_status'));

        $stats = [
            Stat::make('', 'Pulse')->description($pulse ? 'Enabled' : 'Disabled')
                ->icon('heroicon-o-presentation-chart-line')->url($pulse ? PulsePage::getUrl() : null)
                ->descriptionColor($pulse ? 'success' : 'danger'),
            Stat::make('', 'Horizon')->icon('heroicon-o-queue-list')->description($status)
                ->descriptionColor(['Active' => 'success', 'Inactive' => 'danger', 'Paused' => 'warning'][$status])
                ->url(HorizonPage::getUrl()),
        ];

        if (config('telescope.enabled')) {
            $stats[] = Stat::make('', 'Telescope')->descriptionColor($telescope ? 'success' : 'danger')
                ->description($telescope ? 'Enabled' : 'Disabled')
                ->url($telescope ? TelescopePage::getUrl() : null)
                ->icon('heroicon-o-magnifying-glass');
        }

        return $stats;
    }
}
