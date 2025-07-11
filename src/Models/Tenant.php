<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Models;

use Atendwa\Msingi\Model;
use Atendwa\Support\Concerns\Models\UsesSlugs;
use Filament\Models\Contracts\HasCurrentTenantLabel;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Tenant extends Model implements HasCurrentTenantLabel, HasName
{
    use UsesSlugs;

    public string $icon = 'heroicon-o-building-office';

    public function getFilamentName(): string
    {
        $column = 'department_short_name';

        return match ($this->getAttribute('is_default')) {
            default => asString($this->getAttribute($column) ?? $this->name()),
            true => $this->name(),
        };
    }

    public function getSlugFrom(): string
    {
        return 'department_short_name';
    }

    /**
     * @return BelongsToMany<BaseUser, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            BaseUser::class,
            'tenant_user',
            'tenant_id',
            'username',
            'id',
            'username'
        );
    }

    public function syncTenantAccess(): void
    {
        $detach = [];
        $attach = [];
        if ($this->wasChanged('head_username')) {
            $detach[] = $this->getAttribute('head_username');
            $attach[] = $this->getAttribute('head_username');
            $detach[] = $this->getOriginal('head_username');
        }

        if ($this->wasChanged('delegate_username')) {
            $detach[] = $this->getAttribute('delegate_username');
            $detach[] = $this->getOriginal('delegate_username');
            $attach = $this->getAttribute('delegate_username');
        }

        $this->users()->detach($detach);
        $this->users()->attach($attach);
    }

    /**
     * @return BelongsTo<BaseUser, $this>
     */
    public function head(): BelongsTo
    {
        return $this->belongsTo(BaseUser::class, 'head_username', 'username');
    }

    /**
     * @return BelongsTo<Department, $this>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_short_name', 'short_name');
    }

    /**
     * @return BelongsTo<BaseUser, $this>
     */
    public function delegate(): BelongsTo
    {
        return $this->belongsTo(BaseUser::class, 'delegate_username', 'username');
    }

    public function getCurrentTenantLabel(): string
    {
        return 'Active Workspace';
    }

    protected static function booted(): void
    {
        static::created(function (Tenant $tenant): void {
            $tenant = $tenant->load('users');

            $head = $tenant->getAttribute('head_username');

            if ($tenant->users->filter(fn (BaseUser $user): bool => $user->getAttribute('username') === $head)->count() === 0) {
                $tenant->users()->attach($head);
            }

            $delegate = $tenant->getAttribute('delegate_username');

            if (filled($delegate) && $tenant->users->filter(fn (BaseUser $user): bool => $user->getAttribute('username') === $delegate)->count() === 0) {
                $tenant->users()->attach($delegate);
            }
        });

        static::updated(fn (Tenant $tenant) => DB::transaction(fn () => $tenant->syncTenantAccess()));
    }
}
