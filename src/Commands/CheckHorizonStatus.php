<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Commands;

use Illuminate\Console\Command;
use Laravel\Horizon\Contracts\MasterSupervisorRepository;

class CheckHorizonStatus extends Command
{
    /**
     * @var string
     */
    protected $signature = 'horizon:check-status';

    /**
     * @var string
     */
    protected $description = 'Get the current status of Horizon';

    public function handle(MasterSupervisorRepository $masterSupervisorRepository): void
    {
        $status = 'Active';

        $masters = collect($masterSupervisorRepository->all());

        if ($masters->isEmpty()) {
            $status = 'Inactive';
        }

        $masters = $masters->map(fn ($master): array => (array) $master);

        if ($masters->contains(fn ($master): bool => $master['status'] === 'paused')) {
            $status = 'Paused';
        }

        if (app()->runningInConsole()) {
            $this->info('Horizon is currently ' . $status);

            return;
        }

        session(['horizon_status' => $status]);
    }
}
