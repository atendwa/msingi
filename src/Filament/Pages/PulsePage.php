<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Pages;

use Atendwa\Msingi\Concerns\Support\HasInsightPageGate;
use Filament\Pages\Page;

class PulsePage extends Page
{
    use HasInsightPageGate;

    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'msingi::filament.pulse';

    protected static ?string $permission = 'viewPulse';

    protected static ?string $slug = 'pulse';

    protected ?string $heading = '';
}
