<?php

namespace Atendwa\Msingi\Providers;

use Exception;
use Filament\Actions\MountableAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class FilamentActionInteractionLoggerServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    protected array $excludedActions = ['refresh', 'back'];

    protected ?string $logName = null;

    public function register(): void {}

    public function boot(): void
    {
        // todo: confirm export and import actions are covered by this

        MountableAction::configureUsing(function (MountableAction $action): void {
            $this->logName = 'Action Interaction Log';

            $action->before(fn () => $this->log($action))->after(fn () => $this->log($action, false));
        });
    }

    /**
     * @throws Exception
     */
    protected function log(MountableAction $action, bool $isBefore = true): void
    {
        $name = $action->getName();
        $user = auth()->user();
        $subject = null;

        if (! $user instanceof Model || in_array($name, $this->excludedActions)) {
            return;
        }

        $type = $isBefore ? ' initiated' : ' completed';

        $log = activityLog()
            ->event(str($name . ' action' . $type)->headline()->squish()->toString())
            ->useLog($this->logName)->causedBy($user);

        if (method_exists($action, 'getRecord')) {
            $subject = $action->getRecord();
        }

        if ($subject instanceof Model) {
            $log = $log->performedOn($subject);
        }

        $log->log($user->name() . $type . ' action:' . $name . ' at ' . now()->toDateTimeString());
    }
}
