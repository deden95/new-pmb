<?php

namespace App\Filament\Resources\WaveResource\Pages;

use App\Filament\Resources\WaveResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateWave extends CreateRecord
{
    protected static string $resource = WaveResource::class;

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Berhasil')
            ->body('Data Gelombang berhasil ditambahkan.')
            ->success()
            ->send();
            $this->redirect(WaveResource::getUrl('index')); // Kembali ke halaman daftar
    }
}
