<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Models\User;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PaymentResource;
use App\Notifications\Candidate;
use Filament\Notifications\Notification;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->record;
        $user = $record->user;
        $form = $user->getForm;

        if ($data['status'] === 'approved' && $record->type_payment === 'form') {
            $form->is_paid_registration = $record->created_at;
            $user->notify(new Candidate(
                'Pembayaran',
                'Selamat, pembayaran pendaftaran Anda telah diterima. Silahkan lengkapi data diri Anda untuk melanjutkan proses pendaftaran.'
            ));
        } elseif ($data['status'] === 'rejected' && $record->type_payment === 'form') {
            $form->is_paid_registration = null;
            $user->notify(new Candidate(
                'Pembayaran',
                'Maaf, pembayaran pendaftaran Anda ditolak. Silahkan upload ulang bukti pembayaran.'
            ));
        }

        $form->save();

        // Menambahkan notifikasi setelah berhasil menyimpan
        Notification::make()
            ->title('Pembayaran berhasil diperbarui')
            ->success()
            ->send();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
