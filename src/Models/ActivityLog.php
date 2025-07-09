<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Models;

use Atendwa\Support\Concerns\Models\HasModelUtilities;
use Atendwa\Support\Contracts\HasFilamentTabs;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity implements HasFilamentTabs
{
    use HasModelUtilities;

    protected $table = 'activity_log';

    public static function getFilamentTabs(): array
    {
        return [
            'Authentication',
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
}
