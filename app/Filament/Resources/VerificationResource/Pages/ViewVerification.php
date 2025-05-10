<?php

namespace App\Filament\Resources\VerificationResource\Pages;

use App\Filament\Resources\VerificationResource;
use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewVerification extends ViewRecord
{
    protected static string $resource = VerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit Verifikasi'),
            Actions\Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-left')
                ->url($this->getResource()::getUrl('index')),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                // Data Pribadi
                Section::make('Data Pribadi')
                    ->schema([
                        TextEntry::make('user.name')->label('Nama Lengkap'),
                        TextEntry::make('user.email')->label('Email'),
                        TextEntry::make('user.phone')->label('No. HP'),
                        TextEntry::make('national_id')->label('NIK'),
                        TextEntry::make('gender')->label('Jenis Kelamin'),
                        TextEntry::make('birth_place_city')->label('Tempat Lahir'),
                        TextEntry::make('birth_date')->label('Tanggal Lahir')->date(),
                        TextEntry::make('religion')->label('Agama'),
                    ])
                    ->columns(3),
                
                // Alamat
                Section::make('Alamat')
                    ->schema([
                        TextEntry::make('address')->label('Alamat Lengkap')->columnSpanFull(),
                        TextEntry::make('province')->label('Provinsi'),
                        TextEntry::make('city')->label('Kota/Kabupaten'),
                        TextEntry::make('subdistrict')->label('Kecamatan'),
                        TextEntry::make('postal_code')->label('Kode Pos'),
                    ])
                    ->columns(3),
                
                // Pendidikan
                Section::make('Pendidikan Terakhir')
                    ->schema([
                        TextEntry::make('last_education')->label('Jenjang'),
                        TextEntry::make('education_name')->label('Nama Sekolah/Kampus'),
                        TextEntry::make('education_major')->label('Jurusan'),
                        TextEntry::make('education_graduation_year')->label('Tahun Lulus'),
                    ])
                    ->columns(2),
                
                // Orang Tua
                Section::make('Data Orang Tua')
                    ->schema([
                        Section::make('Ayah')
                            ->schema([
                                TextEntry::make('father_name')->label('Nama'),
                                TextEntry::make('father_job')->label('Pekerjaan'),
                                TextEntry::make('father_phone')->label('No. HP'),
                            ])
                            ->columns(3),
                            
                        Section::make('Ibu')
                            ->schema([
                                TextEntry::make('mother_name')->label('Nama'),
                                TextEntry::make('mother_job')->label('Pekerjaan'),
                                TextEntry::make('mother_phone')->label('No. HP'),
                            ])
                            ->columns(3),
                    ]),
                
                // Dokumen Pendukung
                Section::make('Dokumen Pendukung')
                    ->schema([
                        $this->getMediaEntry('ktp', 'KTP'),
                        $this->getMediaEntry('kk', 'Kartu Keluarga'),
                        $this->getMediaEntry('foto', 'Pas Foto'),
                        $this->getMediaEntry('ijazah', 'Ijazah Terakhir'),
                    ])
                    ->columns(2),
            ]);
    }

    protected function getMediaEntry(string $collection, string $label)
    {
        return ImageEntry::make($collection.'_image')
            ->label($label)
            ->getStateUsing(function ($record) use ($collection) {
                $media = $record->getFirstMedia($collection);
                if ($media) {
                    // Jika ada media, tampilkan gambar
                    return [$media->getUrl()];
                }
                // Jika tidak ada media, tampilkan teks "File Belum Diunggah"
                return 'File Belum Diunggah';
            })
            ->extraImgAttributes([
                'class' => 'w-full h-40 object-contain border rounded-lg cursor-pointer',
                'onclick' => 'window.open(this.src, "_blank")'
            ])
            ->defaultImageUrl(asset('images/document-placeholder.png'))
            ->height(200);
    }
}