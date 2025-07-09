<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Pages;

use Atendwa\Msingi\Concerns\Support\HasInsightPageGate;
use Filament\Pages\Page;

class TelescopePage extends Page
{
    use HasInsightPageGate;

    protected static string $view = 'msingi::filament.telescope';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $permission = 'viewTelescope';

    protected static ?string $slug = 'telescope';

    protected ?string $heading = '';
}
