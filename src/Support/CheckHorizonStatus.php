<?php

namespace Atendwa\Msingi\Support;

use Laravel\Horizon\Contracts\MasterSupervisorRepository;

readonly class CheckHorizonStatus
{
    public function __construct(private MasterSupervisorRepository $masterSupervisorRepository) {}

    public function execute(): bool
    {
        $masters = collect($this->masterSupervisorRepository->all());

        if ($masters->isEmpty()) {
            return false;
        }

        $masters = $masters->map(fn ($master): array => (array) $master);

        return ! $masters->contains(fn ($master): bool => $master['status'] === 'paused');
    }
}
