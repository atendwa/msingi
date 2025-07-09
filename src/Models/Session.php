<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public string $icon = 'heroicon-o-window';

    protected function casts(): array
    {
        return [
            'last_activity' => 'timestamp',
            'ip_address' => 'string',
            'user_agent' => 'string',
            'user_id' => 'integer',
            'id' => 'string',
        ];
    }
}
