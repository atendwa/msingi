<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Concerns\Models;

use Atendwa\Msingi\Models\BaseUser;
use Atendwa\Support\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Throwable;

trait HasAuditAttributes
{
    /**
     * @throws Throwable
     */
    public static function bootHasAuditAttributes(): void
    {
        static::creating(function (Auditable $auditable): void {
            if (blank($auditable->asModel()->getAttribute('created_by'))) {
                $id = self::authId();

                $auditable->trail('created', $id);
                $auditable->trail('updated', $id);
            }

            self::populateRequestColumns($auditable->asModel());
        });

        static::updating(function (Auditable $auditable): void {
            $auditable->trail('updated', self::authId());
            self::populateRequestColumns($auditable->asModel());
        });
    }

    public function trail(string $trail, ?int $authId = null, bool $persist = false): void
    {
        $this->setAttribute($trail . '_by', $authId ?? auth()->id());
        $this->setAttribute($trail . '_at', now());

        if ($persist) {
            $this->update();
        }
    }

    /**
     * @return BelongsTo<BaseUser, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(BaseUser::class, 'created_by');
    }

    /**
     * @return BelongsTo<BaseUser, $this>
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(BaseUser::class, 'updated_by');
    }

    /**
     * @return BelongsTo<BaseUser, $this>
     */
    public function deleter(): BelongsTo
    {
        return $this->belongsTo(BaseUser::class, 'deleted_by');
    }

    /**
     * @return BelongsTo<BaseUser, $this>
     */
    public function actioner(): BelongsTo
    {
        return $this->belongsTo(BaseUser::class, 'actioned_by');
    }

    /**
     * @return BelongsTo<BaseUser, $this>
     */
    public function restoror(): BelongsTo
    {
        return $this->belongsTo(BaseUser::class, 'restored_by');
    }

    public function canFilterByAuthor(): bool
    {
        return true;
    }

    /**
     * @return array<string, string>
     */
    public function trails(): array
    {
        return [];
    }

    /**
     * @return array<string, string>
     */
    public function auditAttributes(): array
    {
        return [];
    }

    /**
     * @throws Throwable
     */
    private static function authId(): ?int
    {
        $user = auth()->user();

        if (blank($user)) {
            $user = systemUser();
        }

        $column = 'id';

        return (int) $user->string($column);
    }

    private static function populateRequestColumns(Model $model): void
    {
        $model->setAttribute('user_agent', request()->userAgent());
        $model->setAttribute('ip_address', request()->ip());
    }
}
