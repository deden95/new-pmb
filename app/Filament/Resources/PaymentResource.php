<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use App\Models\User;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;


class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Payment';

    protected static ?string $modelLabel = 'Pembayaran';
    protected static ?string $pluralModelLabel = 'Data Pembayaran';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([  
                    
                TextColumn::make('bank')
                    ->label('Bank'), 

                TextColumn::make('user.name')
                ->label('Pengguna') 
                ->searchable(),

                TextColumn::make('account_number')
                    ->label('Nomor Hp'), 

                TextColumn::make('amount')
                    ->label('Jumlah') 
                    ->money('IDR', true),

                TextColumn::make('date')
                    ->label('Tanggal') 
                    ->date(),

                TextColumn::make('type_payment')
                    ->label('Jenis Pembayaran'), 

                TextColumn::make('code')
                    ->label('Kode'), 

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('note')
                    ->label('Catatan') 
                    ->limit(30),

                TextColumn::make('user.getForm.prodi.nama_prodi')
                    ->label('Program Studi') 
                    ->sortable(),
            ])
            ->filters([
                // filter jika ada
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required(),
                Textarea::make('note')->nullable(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}