<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Models;

use Atendwa\Msingi\Model;

class ApiKey extends Model
{
    public string $icon = 'heroicon-o-key';

    protected $table = 'personal_access_tokens';

    protected function casts(): array
    {
        return ['expires_at' => 'datetime'];
    }
}
