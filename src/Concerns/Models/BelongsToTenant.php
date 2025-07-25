<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Concerns\Models;

use Atendwa\Msingi\Models\Tenant;
use Atendwa\Msingi\Scopes\TenantScope;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Throwable;

trait BelongsToTenant
{
    /**
     * @throws Throwable
     */
    public static function bootBelongsToTenant(): void
    {
        static::creating(function (Model $model): void {
            if (blank($model->getAttribute('tenant_id'))) {
                $id = tenantID();

                if (blank($id)) {
                    $id = systemTenant()->getKey();
                }

                $model->setAttribute('tenant_id', $id);
            }
        });

        if (any([! Filament::getCurrentPanel()?->hasTenancy(), auth()->guest(), app()->runningInConsole(), ! self::isScopedToTenant()])) {
            return;
        }

        static::addGlobalScope(new TenantScope());
    }

    /**
     * @return BelongsTo<Model, $this>
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function canFilterByTenant(): bool
    {
        return true;
    }

    public static function isScopedToTenant(): bool
    {
        return true;
    }

    public function tenantId(): int
    {
        return (int) $this->string('tenant_id');
    }
}
