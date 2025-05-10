<?php


namespace App\Filament\Resources;

use App\Filament\Resources\ProdiResource\Pages;
use App\Filament\Resources\ProdiResource\RelationManagers;
use App\Models\Prodi;
use App\Models\Fakultas; 
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProdiResource extends Resource
{
    protected static ?string $model = Prodi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): string
    {
        return 'Mater Data';
    }


    public static function getModelLabel(): string
    {
        return 'Program Studi'; 
    }
    
    public static function getPluralModelLabel(): string
    {
        return 'Daftar Prodi'; 
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama_prodi')
                ->label('Nama Program Studi')
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('jenjang')
                ->label('Jenjang')
                ->options([                    
                    'S1' => 'Sarjana (S1)'                
                ])
                ->required(),

            Forms\Components\Select::make('fakultas')
                ->label('Fakultas')
                ->options(Fakultas::pluck('nama_fakultas', 'nama_fakultas')) // Ambil dari tabel fakultas
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('akreditasi')
                ->label('Akreditasi')
                ->maxLength(5),

            Forms\Components\Toggle::make('tes_ujian')
                ->label('Tes Ujian')
                ->default(false),

            Forms\Components\Toggle::make('tes_wawancara')
                ->label('Tes Wawancara')
                ->default(false),

            Forms\Components\Toggle::make('tes_kesehatan')
                ->label('Tes Kesehatan')
                ->default(false),

            Forms\Components\Toggle::make('status')
                ->label('Status')
                ->default(false),   
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nama_prodi')
                ->label('Program Studi')
                ->searchable(),

            Tables\Columns\TextColumn::make('jenjang')
                ->label('Jenjang'),

            Tables\Columns\TextColumn::make('fakultas') 
            ->label('Fakultas'),

            Tables\Columns\TextColumn::make('akreditasi')
                ->label('Akreditasi'),

            Tables\Columns\IconColumn::make('tes_ujian')
                ->label('Tes Ujian')
                ->boolean(),

            Tables\Columns\IconColumn::make('tes_wawancara')
                ->label('Tes Wawancara')
                ->boolean(),

            Tables\Columns\IconColumn::make('tes_kesehatan')
                ->label('Tes Kesehatan')
                ->boolean(),

            Tables\Columns\IconColumn::make('status')
                ->label('Status')
                ->boolean(),    
            
        ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProdis::route('/'),
            'create' => Pages\CreateProdi::route('/create'),
            'edit' => Pages\EditProdi::route('/{record}/edit'),
        ];
    }
}