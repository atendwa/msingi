<?php

namespace Atendwa\Msingi\Providers;

use Exception;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use function Illuminate\Support\defer;
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

        Action::configureUsing(function (Action $action): void {
            $this->logName = 'Action Interaction Log';

            $action->before(fn () => $this->log($action))->after(fn () => $this->log($action, false));
        });
    }

    /**
     * @throws Exception
     */
    protected function log(Action $action, bool $isBefore = true): void
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

        $description = $user->name() . $type . ' action:' . $name . ' at ' . now()->toDateTimeString();

        defer(fn () => $log->log($description))->name('filament-action-interaction-log');
    }
}
