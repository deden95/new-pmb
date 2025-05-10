<?php

namespace App\Filament\Resources\WaveResource\Pages;

use App\Filament\Resources\WaveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

class ListWaves extends ListRecords
{
    protected static string $resource = WaveResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Gelombang'),
        ];
    }
    

    protected function getTableActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make()
                ->after(function () {
                    Notification::make()
                        ->title('Berhasil')
                        ->body('Data Gelombang berhasil dihapus.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
