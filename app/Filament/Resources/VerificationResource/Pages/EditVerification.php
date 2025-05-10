<?php

namespace App\Filament\Resources\VerificationResource\Pages;

use App\Filament\Resources\VerificationResource;
use App\Helper\StatusHelper;
use App\Notifications\Candidate;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVerification extends EditRecord
{
    protected static string $resource = VerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-left')
                ->url($this->getResource()::getUrl('view', ['record' => $this->record])),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            \Filament\Forms\Components\Section::make('Verifikasi Formulir')
                ->schema([
                    \Filament\Forms\Components\Select::make('status')
                        ->options([
                            'approved' => 'Disetujui',
                            'rejected' => 'Ditolak',
                        ])
                        ->required()
                        ->label('Status Verifikasi'),
                        
                    \Filament\Forms\Components\Toggle::make('is_via_online')
                        ->label('Pendaftaran Online'),
                        
                    \Filament\Forms\Components\Toggle::make('is_submitted')
                        ->label('Formulir Dikumpulkan'),
                        
                    \Filament\Forms\Components\Textarea::make('note')
                        ->label('Catatan')
                        ->hidden(fn (\Filament\Forms\Get $get) => $get('status') === 'approved'),
                ]),
        ];
    }

    protected function afterSave(): void
    {
        $form = $this->record;
        
        if ($form->status == 'approved' && !$form->no_exam) {
            $form->no_exam = $form->wave->code . '-' . $form->prodi->code . '-' . $form->id;
            $form->save();
        }
        
        // Kirim notifikasi ke user
        $form->user->notify(
            new Candidate(
                'Status Pendaftaran',
                'Formulir pendaftaran Anda telah ' . StatusHelper::getStatus($form->status)
            )
        );
        
        $this->refreshFormData(['no_exam']);
    }
}