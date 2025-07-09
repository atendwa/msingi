<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface Tenantable
{
    public function tenant(): BelongsTo;

    public function canFilterByTenant(): bool;

    public static function isScopedToTenant(): bool;

    public function tenantId(): int;
}
