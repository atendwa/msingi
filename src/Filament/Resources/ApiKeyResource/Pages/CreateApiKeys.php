<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\ApiKeyResource\Pages;

use Atendwa\Filakit\Pages\CreateRecord;
use Atendwa\Msingi\Filament\Resources\ApiKeyResource;
use Atendwa\Msingi\Models\ApiKey;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Throwable;

class CreateApiKeys extends CreateRecord
{
    protected static string $resource = ApiKeyResource::class;

    /**
     * @param  array<string>  $data
     */
    protected function handleRecordCreation(array $data): Model
    {
        try {
            $user = systemUser();

            ApiKey::query()
                ->where(['tokenable_type' => $user::class, 'tokenable_id' => $user->getKey(), 'name' => $data['name']])
                ->delete();

            $date = filled($data['expires_at']) ? Carbon::parse($data['expires_at']) : null;

            $key = $user->createToken($data['name'], expiresAt: $date);

            notify($key->plainTextToken)->success('API Key Created!');

            return $key->accessToken;
        } catch (Throwable $throwable) {
            notify($throwable)->error('Failed to create API key.');
        }

        return new ApiKey();
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }
}
