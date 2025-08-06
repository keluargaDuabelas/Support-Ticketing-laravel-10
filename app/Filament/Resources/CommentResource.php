<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\Pages\RespondComment;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BalasResource\Pages\Balas;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Gate;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tiket.name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\TextInput::make('tiket_id')
                    ->required()
                    ->maxLength(255),



            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tiket.nomor')
                ->label('Nomor Tiket')
                ->searchable(),
                Tables\Columns\TextColumn::make('tiket.name')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('tiket.kategori.name')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('tiket.subkategori.description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),

                    Tables\Columns\TextColumn::make('tiket.status')
                    ->label('status')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'warning',
                        'resolved' => 'success',
                        'in_progress' => 'danger',
                    }),

                    Tables\Columns\ViewColumn::make('upload')
                    ->label('upload file')
                    ->view('components.pdf-preview')
                ->searchable(),
                Tables\Columns\TextColumn::make('tiket.user.name')
                ->searchable(),

            ])
            ->defaultGroup('tiket.status')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('respond')
                // ->label('Respond to Comment')
                ->icon('heroicon-o-rectangle-stack')
                ->color('primary')
                ->openUrlInNewTab()
                ->url(fn ($record) => route('filament.tiket.resources.comments.respond', $record->id))
                ->visible(fn ($record) => Gate::allows('respond', $record)),




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
            'index' => Pages\ManageComments::route('/'),
            'respond' => Pages\RespondComment::route('/respond/{record}'), // <- Route ini penting


        ];
    }
}
