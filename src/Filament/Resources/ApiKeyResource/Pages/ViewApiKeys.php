<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\ApiKeyResource\Pages;

use Atendwa\Filakit\Actions\Action;
use Atendwa\Filakit\Pages\ViewRecord;
use Atendwa\Msingi\Filament\Resources\ApiKeyResource;
use Atendwa\Msingi\Models\ApiKey;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class ViewApiKeys extends ViewRecord
{
    protected static string $resource = ApiKeyResource::class;

    protected bool $deletable = true;

    protected function actions(): array
    {
        return [
            Action::make('regenerate')->color('success')->requiresConfirmation()->label('Regenerate')
                ->icon('heroicon-o-arrow-path')->action(function (): void {
                    try {
                        $this->regenerate();

                        $this->refresh();
                    } catch (Throwable $throwable) {
                        notify($throwable)->error();
                    }
                }),
        ];
    }

    /**
     * @throws Throwable
     */
    private function regenerate(): void
    {
        DB::transaction(function (): void {
            $user = systemUser();

            $key = asInstanceOf($this->getRecord(), ApiKey::class);
            $date = $key->getAttribute('expires_at');

            $date = match ($date instanceof Carbon) {
                true => Carbon::parse($date),
                false => null
            };

            $new = $user->createToken(asString($key->getAttribute('name')), expiresAt: $date);
            $key->delete();

            notify($new->plainTextToken)->success('API Key Regenerated!');
        });
    }
}
