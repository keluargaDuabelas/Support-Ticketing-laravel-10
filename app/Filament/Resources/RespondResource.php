<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RespondResource\Pages;
use App\Filament\Resources\RespondResource\RelationManagers;
use App\Models\Respond;
use App\Models\Response;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RespondResource extends Resource
{
    protected static ?string $model = Response::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                Tables\Columns\TextColumn::make('comment.tiket.nomor')
                ->label('nomor')
                ->searchable(),
                Tables\Columns\TextColumn::make('comment.tiket.name')
                    ->label('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('comment.tiket.kategori.name')
                ->label('kategori')
                ->searchable(),
                Tables\Columns\TextColumn::make('message')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('comment.tiket.user.name')
                    ->label('user')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('user.name')
                    ->label('respon')
                    ->searchable(),
                    Tables\Columns\ViewColumn::make('comment.upload')
                    ->label('upload file')
                    ->view('components.pdf-preview')
                ->searchable(),




            ])

            ->defaultGroup('comment.tiket.name')


            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
           ;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageResponds::route('/'),
        ];
    }
}
