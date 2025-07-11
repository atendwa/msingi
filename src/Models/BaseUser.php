<?php

namespace Atendwa\Msingi\Models;

use Atendwa\Filakit\Panel;
use Atendwa\Filakit\PanelProvider;
use Atendwa\Msingi\Concerns\Models\AccessSystemInsights;
use Atendwa\Msingi\Concerns\Models\HasAuditAttributes;
use Atendwa\Msingi\Contracts\Auditable;
use Atendwa\Msingi\Contracts\InsightsUser;
use Atendwa\Support\Concerns\Models\HasModelUtilities;
use Atendwa\Support\Concerns\Models\SanitiseNullableColumns;
use Atendwa\Whitelist\Concerns\CanBeWhitelisted;
use Exception;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Throwable;

class BaseUser extends User implements Auditable, FilamentUser, HasAvatar, HasTenants, InsightsUser
{
    use AccessSystemInsights;
    use CanBeWhitelisted;
    use HasApiTokens;
    use HasAuditAttributes;
    use HasModelUtilities;
    use HasRoles;
    use Notifiable;
    use SanitiseNullableColumns;
    use SoftDeletes;

    public string $icon = 'heroicon-o-users';

    protected $table = 'users';

    protected $guarded = ['id'];

    /**
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

    public function getFilamentAvatarUrl(): ?string
    {
        return null;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function canViewSystemInsights(): bool
    {
        return $this->hasAnyRole(['super_admin', 'developer']);
    }

    public function type(): string
    {
        $column = 'type';

        return $this->string($column);
    }

    public function isStaff(): bool
    {
        return str($this->type())->is('staff', true);
    }

    public function isStudent(): bool
    {
        return str($this->type())->is('student', true);
    }

    public function isAffiliate(): bool
    {
        return str($this->type())->is('affiliate', true);
    }

    public function isCustom(): bool
    {
        return every([! $this->isStaff(), ! $this->isStudent()]);
    }

    /**
     * @throws Throwable
     */
    public function isSystemStaff(): bool
    {
        if (session()->has('is_system_staff')) {
            return boolval(session('is_system_staff'));
        }

        $column = 'department_short_name';

        $value = str(asString(setting('system_owner:department_short_code')))->is($this->string($column), true);

        session()->put('is_system_staff', $value);

        return $value;
    }

    /**
     * @param  Builder<$this>  $builder
     *
     * @return Builder<$this>
     */
    #[Scope]
    public function students(Builder $builder): Builder
    {
        $column = 'type';

        return $builder->where($column, 'student');
    }

    /**
     * @param  Builder<$this>  $builder
     *
     * @return Builder<$this>
     */
    #[Scope]
    public function staff(Builder $builder): Builder
    {
        $column = 'type';

        return $builder->where($column, 'staff');
    }

    public function canImpersonate(): bool
    {
        return $this->hasRole('super_admin');
    }

    public function canBeImpersonated(): bool
    {
        return ! $this->canImpersonate();
    }

    public function getFilamentName(): string
    {
        $column = 'username';

        return $this->string($column);
    }

    public function initials(): string
    {
        return str($this->name())->explode(' ')
            ->map(fn (string $name) => str($name)->substr(0, 1))
            ->implode('');
    }

    /**
     * @throws Exception
     */
    public function canAccessPanel(Panel|\Filament\Panel $panel): bool
    {
        if ($panel->isDefault()) {
            return true;
        }

        $name = $panel->getId() . 'PanelProvider';

        $provider = collect(app()->getLoadedProviders())->keys()
            ->filter(fn (string $provider) => str($provider)->contains($name, true));

        return asInstanceOf(app($provider->first(), ['app' => app()]),
            PanelProvider::class)::canAccess($panel->getId());
    }

    /**
     * @throws Throwable
     */
    public function canLogIn(): bool
    {
        $column = 'username';

        if ($this->string($column) === systemUsername()) {
            return app()->isLocal();
        }

        if ($this->isStaff()) {
            return true;
        }

        if ($this->isStudent()) {
            return (bool) setting('auth:allow_student_logins');
        }

        return (bool) setting('auth:allow_alt_login');
    }

    /**
     * @throws Throwable
     */
    public function canUseSecondaryLogin(): bool
    {
        $settings = settings(['auth:alt_login_override', 'auth:allow_alt_login']);

        return every([
            $this->isCustom() || $settings->get('auth:alt_login_override', false),
            (bool) $settings->get('auth:allow_alt_login', false),
            $this->isActive(),
        ]);
    }

    /**
     * @return array<int>
     */
    public function departmentIds(): array
    {
        $one = 'delegate_username';
        $two = 'hod_username';
        $three = 'id';

        return Department::query()->where(
            fn (Builder $query) => $query
                ->where($one, $this->getAttribute('username'))
                ->orWhere($two, $this->getAttribute('username'))
        )
            ->pluck($three)->all();
    }

    /**
     * @return BelongsTo<Department, $this>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_short_name', 'short_name');
    }

    /**
     * @return HasOne<Department, $this>
     */
    public function headsDepartment(): HasOne
    {
        return $this->hasOne(Department::class, 'head_username', 'username');
    }

    /**
     * @return HasOne<Department, $this>
     */
    public function delegatesDepartment(): HasOne
    {
        return $this->hasOne(Department::class, 'delegate_username', 'username');
    }

    /**
     * @return HasOne<Tenant, $this>
     */
    public function heads(): HasOne
    {
        return $this->hasOne(Tenant::class, 'head_username', 'username');
    }

    /**
     * @return HasOne<Tenant, $this>
     */
    public function delegates(): HasOne
    {
        return $this->hasOne(Tenant::class, 'delegate_username', 'username');
    }

    /**
     * @return BelongsToMany<Tenant, $this>
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(
            Tenant::class,
            'tenant_user',
            'username',
            'tenant_id',
            'username',
            'id'
        );
    }

    /**
     * @throws Throwable
     */
    public function getDefaultTenant(Panel|\Filament\Panel $panel): ?Model
    {
        $column = 'department_short_name';

        $code = $this->string($column);
        $tenant = null;

        if (filled($code)) {
            $tenant = $this->getTenants($panel)
                ->filter(fn (Tenant $tenant): bool => $tenant->string($column) === $code)
                ->first();
        }

        if ($tenant instanceof Tenant) {
            return $tenant;
        }

        return defaultTenant();
    }

    /**
     * @throws Throwable
     */
    public function canAccessTenant(Model $model): bool
    {
        return boolval(session()->remember(
            'can_access_tenant_' . asString($model->getKey()),
            fn () => $this->tenants()->pluck('id')->contains($model->getKey())
        ));
    }

    /**
     * @return Collection<int, Tenant>
     *
     * @throws Throwable
     */
    public function getTenants(Panel|\Filament\Panel $panel): Collection
    {
        return $this->tenants();
    }

    public function activate(): void
    {
        $this->update(['is_active' => false]);
    }

    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }

    public function isPrivileged(): bool
    {
        return $this->roles->pluck('name')->except('panel_user')->count() > 0;
    }

    protected static function booted(): void
    {
        parent::creating(function (User $user): void {
            if (blank($user->getAttribute('name'))) {
                $name = $user->getAttribute('first_name') . ' ' .
                    $user->getAttribute('other_names') . ' ' .
                    $user->getAttribute('surname');

                $user->setAttribute('name', str($name)->lower()->headline()->squish()->toString());
            }
        });

        parent::created(function (BaseUser $user): void {
            $column = 'department_short_name';
            $field = 'is_default';
            $one = 'id';

            Tenant::query()->limit(2)->select($one)->where(fn (Builder $query) => $query
                ->where($column, $user->string($column))->orWhere($field, true)
            )->each(fn ($tenant) => $user->teams()->attach($tenant));
        });
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @return Attribute<int, string>
     */
    protected function roleNames(): Attribute
    {
        return Attribute::make(fn () => collect($this->roles->pluck('name'))->map(fn ($role) => headline($role))->implode(', '));
    }

    /**
     * @return Collection<int, Tenant>
     */
    private function tenants(): Collection
    {
        $shortname = $this->getAttribute('department_short_name');
        $teams = $this->teams;

        if (blank($shortname)) {
            return $teams;
        }

        $filtered = $teams->filter(fn (Tenant $tenant): bool => ! $tenant->getAttribute('is_default'));

        return match ($filtered->isEmpty()) {
            false => $filtered,
            true => $teams,
        };
    }
}
