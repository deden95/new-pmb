<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VerificationResource\Pages;
use App\Models\Form;
use App\Helper\StatusHelper;
use App\Notifications\Candidate;
use Filament\Forms;
use Filament\Forms\Form as FormsForm;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VerificationResource extends Resource
{
    protected static ?string $model = Form::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $modelLabel = 'Verifikasi Pendaftaran';
    
    public static function form(FormsForm $form): FormsForm
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pendaftaran')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('note')
                            ->label('Catatan')
                            ->nullable(),
                        Forms\Components\Toggle::make('is_via_online')
                            ->label('Via Online')
                            ->required(),
                        Forms\Components\Toggle::make('is_submitted')
                            ->label('Telah Submit')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pendaftar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code_registration')
                    ->label('Kode Pendaftaran'),
                Tables\Columns\TextColumn::make('prodi.nama_prodi')
                    ->label('Program Studi'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'warning',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Pendaftaran')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'submitted' => 'Submitted',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        Forms\Components\Select::make('status')
                            ->options([
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('note')
                            ->label('Catatan'),
                        Forms\Components\Toggle::make('is_via_online')
                            ->label('Via Online'),
                        Forms\Components\Toggle::make('is_submitted')
                            ->label('Telah Submit'),
                    ])
                    ->after(function (Form $form) {
                        if ($form->getRecord()->status === 'approved' && !$form->getRecord()->no_exam) {
                            $form->getRecord()->no_exam = $form->getRecord()->wave->code . '-' . $form->getRecord()->prodi->id . '-' . $form->getRecord()->id;
                        }
                        
                        $form->getRecord()->user->notify(
                            new Candidate(
                                'Pendaftaran',
                                'Formulir anda ' . StatusHelper::getStatus($form->getRecord()->status) . ' oleh panitia'
                            )
                        );
                    }),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVerifications::route('/'),
            'view' => Pages\ViewVerification::route('/{record}'),
            'edit' => Pages\EditVerification::route('/{record}/edit'),
        ];
    }
}