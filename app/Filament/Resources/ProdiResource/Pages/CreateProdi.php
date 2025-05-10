<?php

namespace App\Filament\Resources\ProdiResource\Pages;

use App\Filament\Resources\ProdiResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateProdi extends CreateRecord
{
    protected static string $resource = ProdiResource::class;

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Berhasil!')
            ->body('Data Program Studi berhasil ditambahkan.')
            ->success()
            ->send();

        $this->redirect(ProdiResource::getUrl('index')); // Kembali ke halaman daftar
    }
}