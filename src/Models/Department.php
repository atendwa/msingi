<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Models;

use Atendwa\Msingi\Model;
use Atendwa\Support\Concerns\Models\UsesSlugs;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Throwable;

class Department extends Model
{
    use UsesSlugs;

    public string $icon = 'heroicon-o-building-office-2';

    public function getSlugFrom(): string
    {
        return 'short_name';
    }

    /**
     * @return HasOne<Tenant, $this>
     */
    public function tenant(): HasOne
    {
        return $this->hasOne(Tenant::class, 'department_short_name', 'short_name');
    }

    /**
     * @return HasMany<BaseUser, $this>
     */
    public function users(): HasMany
    {
        return $this->hasMany(BaseUser::class, 'department_short_name', 'short_name');
    }

    /**
     * @return BelongsTo<Department, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_short_name', 'short_name');
    }

    /**
     * @return HasMany<Department, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_short_name', 'short_name');
    }

    /**
     * @return BelongsTo<BaseUser, $this>
     */
    public function head(): BelongsTo
    {
        return $this->belongsTo(BaseUser::class, 'head_username', 'username');
    }

    /**
     * @return BelongsTo<BaseUser, $this>
     */
    public function delegate(): BelongsTo
    {
        return $this->belongsTo(BaseUser::class, 'delegate_username', 'username');
    }

    /**
     * @throws Throwable
     */
    public static function updateOrCreateTenant(Department $department, bool $force = false): void
    {
        if (! config('foundation.departments.auto_create_department_tenant') && ! $force) {
            return;
        }

        $stringable = str($department->name())->headline()->squish();
        $username = systemUser()->getAttribute('username');

        $department->tenant()->updateOrCreate(['department_short_name' => $department->getAttribute('slug')], [
            'delegate_username' => $department->getAttribute('delegate_username') ?? $username,
            'head_username' => $department->getAttribute('head_username') ?? $username,
            'department_short_name' => $department->getAttribute('slug'),
            'description' => $stringable->lower()->title()->toString(),
            'owner_type' => $department->getMorphClass(),
            'owner_id' => $department->getKey(),
            'name' => $stringable->toString(),
        ]);
    }

    protected static function booted(): void
    {
        parent::created(fn (Department $department) => self::updateOrCreateTenant($department));
        parent::updated(fn (Department $department) => self::updateOrCreateTenant($department));
    }
}
