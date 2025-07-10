<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Pages;

use Atendwa\Msingi\Concerns\Support\HasInsightPageGate;
use Atendwa\Msingi\Filament\Clusters\Insights;
use Filament\Pages\Page;

class PulsePage extends Page
{
    use HasInsightPageGate;

    protected static string $view = 'msingi::filament.pulse';

    protected static ?string $activeNavigationIcon = 'heroicon-s-presentation-chart-line';
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static ?string $cluster = Insights::class;

    protected static ?string $permission = 'viewPulse';

    protected static ?string $slug = 'pulse';

    protected ?string $heading = '';
}
