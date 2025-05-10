<?php

namespace App\Filament\Resources\WaveResource\Pages;

use App\Filament\Resources\WaveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditWave extends EditRecord
{
    protected static string $resource = WaveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Berhasil')
            ->body('Data Gelombang berhasil diperbarui.')
            ->success()
            ->send();
            $this->redirect(WaveResource::getUrl('index')); // Kembali ke halaman daftar
    }
}
