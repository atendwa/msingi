<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Pages;

use Atendwa\Msingi\Concerns\Support\HasInsightPageGate;
use Atendwa\Msingi\Filament\Clusters\Insights;
use Filament\Pages\Page;

class TelescopePage extends Page
{
    use HasInsightPageGate;

    protected static ?string $activeNavigationIcon = 'heroicon-s-magnifying-glass';

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $permission = 'viewTelescope';

    protected static ?string $cluster = Insights::class;

    protected static ?string $slug = 'telescope';

    protected ?string $heading = '';
}
