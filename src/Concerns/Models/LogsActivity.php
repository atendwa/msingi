<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Concerns\Models;

use Spatie\Activitylog\LogOptions;
use Throwable;

trait LogsActivity
{
    use \Spatie\Activitylog\Traits\LogsActivity;

    public function logSubjectDetails(): string
    {
        return str(class_basename($this::class))->append(' -> ' . $this->logSubjectIdentifier())->toString();
    }

    /**
     * @throws Throwable
     */
    public function getActivitylogOptions(): LogOptions
    {
        $user = auth()->user();

        if (auth()->guest()) {
            $user = systemUser();
        }

        $username = asString($user?->username ?? 'System');

        return LogOptions::defaults()->logExcept($this->excludedFromLog())->useLogName('Audit')->logAll()
            ->setDescriptionForEvent(fn (string $eventName) => $username . $eventName . $this->logSubjectDetails())
            ->logOnlyDirty();
    }

    protected function logSubjectIdentifier()
    {
        return $this->getAttribute('name') ?: $this->getAttribute('slug') ?: '#' . $this->getKey();
    }

    /**
     * @return string[]
     */
    protected function excludedFromLog(): array
    {
        return ['created_at', 'updated_at'];
    }
}
