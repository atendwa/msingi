<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Pages;

use Atendwa\Msingi\Concerns\Support\HasInsightPageGate;
use Atendwa\Msingi\Filament\Clusters\Insights;
use Filament\Pages\Page;

class HorizonPage extends Page
{
    use HasInsightPageGate;

    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'msingi::filament.horizon';

    protected static ?string $permission = 'viewHorizon';

    protected static ?string $cluster = Insights::class;

    protected static ?string $slug = 'horizon';

    protected ?string $heading = '';
}
