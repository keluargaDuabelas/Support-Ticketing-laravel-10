<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubKategoriResource\Pages;
use App\Filament\Resources\SubKategoriResource\RelationManagers;
use App\Models\SubKategori;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubKategoriResource extends Resource
{
    protected static ?string $model = SubKategori::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('kategori_id')
                ->label('kategori')
                ->relationship('kategori', 'name') // Mengambil data dari relasi kecamatan
                ->required(),
                    Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([


                Tables\Columns\TextColumn::make('kategori.name')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('description')
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSubKategoris::route('/'),
        ];
    }
}
