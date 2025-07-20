<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Models;

use Atendwa\Filakit\Concerns\UsesFilamentTabs;
use Atendwa\Filakit\Contracts\HasFilamentTabs;
use Filament\Support\Contracts\HasIcon;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity implements HasFilamentTabs, HasIcon
{
    use UsesFilamentTabs;

    public string $icon = 'heroicon-o-document-text';

    protected $table = 'activity_log';

    public static function getFilamentTabs(): array
    {
        return [
            'Authentication', 'Page Visits',
        ];
    }

    public function getFilamentTabColumn(): string
    {
        return 'log_name';
    }

    public function finalSuccessState(): string
    {
        return '';
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }
}
