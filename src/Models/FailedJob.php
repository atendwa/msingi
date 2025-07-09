<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Models;

use Atendwa\Support\Concerns\Models\Prunable;
use Illuminate\Database\Eloquent\Model;

class FailedJob extends Model
{
    use Prunable;

    public string $icon = 'heroicon-o-exclamation-triangle';

    protected function casts(): array
    {
        return [
            'failed_at' => 'datetime',
            'connection' => 'string',
            'exception' => 'string',
            'payload' => 'array',
            'queue' => 'string',
            'uuid' => 'string',
            'id' => 'integer',
        ];
    }
}
