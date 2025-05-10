<?php

namespace App\Filament\Resources\ProdiResource\Pages;

use App\Filament\Resources\ProdiResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditProdi extends EditRecord
{
    protected static string $resource = ProdiResource::class;

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Berhasil!')
            ->body('Data Program Studi berhasil diperbarui.')
            ->success()
            ->send();

        $this->redirect(ProdiResource::getUrl('index')); // Kembali ke halaman daftar
    }
}
