<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WaveResource\Pages;
use App\Filament\Resources\WaveResource\RelationManagers;
use App\Models\Wave;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WaveResource extends Resource
{
    protected static ?string $model = Wave::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    
    // Tambahkan ini
    public static function getNavigationGroup(): string
    {
        return 'Mater Data';
    }

    public static function getModelLabel(): string
    {
        return 'Gelombang';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Daftar Gelombang';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('code')->required(),
            Forms\Components\TextInput::make('gelombang')->required(),
            Forms\Components\TextInput::make('tahun_akademik')->required(),
            Forms\Components\DatePicker::make('awal_daftar')->required(),
            Forms\Components\DatePicker::make('akhir_daftar')->required(),
            Forms\Components\DatePicker::make('tes_tulis')->required(),
            Forms\Components\DatePicker::make('tes_kesehatan')->required(),
            Forms\Components\DatePicker::make('wawancara')->required(),
            Forms\Components\TextInput::make('price_reg')->required(),
            Forms\Components\Toggle::make('active')->label('Aktif'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->label('Kode'),
                Tables\Columns\TextColumn::make('gelombang'),
                Tables\Columns\TextColumn::make('tahun_akademik')->label('Tahun Akademik'),
                Tables\Columns\TextColumn::make('awal_daftar')->date(),
                Tables\Columns\TextColumn::make('akhir_daftar')->date(),
                Tables\Columns\TextColumn::make('tes_tulis')->date(),
                Tables\Columns\TextColumn::make('tes_kesehatan')->date(),
                Tables\Columns\TextColumn::make('wawancara')->date(),
                Tables\Columns\TextColumn::make('price_reg')
                ->label('Biaya Registrasi')
                ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),            
                Tables\Columns\IconColumn::make('active')
                ->label('Status')
                ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWaves::route('/'),
            'create' => Pages\CreateWave::route('/create'),
            'edit' => Pages\EditWave::route('/{record}/edit'),
        ];
    }
}