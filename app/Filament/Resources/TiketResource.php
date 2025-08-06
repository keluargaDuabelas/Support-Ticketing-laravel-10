<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TiketResource\Pages;
use App\Filament\Resources\TiketResource\RelationManagers;
use App\Models\Comment;
use App\Models\Tiket;
use App\Models\SubKategori;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Actions\CreateAction;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget;

class TiketResource extends Resource
{
    protected static ?string $model = Tiket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nomor')
                    ->label('Nomor')
                    ->default(fn () => Tiket::generateNomor()) // Nomor otomatis dihasilkan
                    ->readOnly() // Tidak dapat diubah manual
                    ->required(),
                    Forms\Components\Select::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'name') // Relasi ke model kategori
                    ->required()
                    ->placeholder('Pilih kategori')
                    ->reactive() // Aktifkan fitur dinamis
                    ->afterStateUpdated(fn ($state, callable $set) => $set('sub_kategori_id', null)), // Reset subkategori

                // Dropdown untuk SubKategori
                Forms\Components\Select::make('sub_kategori_id')
                    ->label('Subkategori')
                    ->relationship('subKategori', 'description') // Relasi ke model subkategori
                    ->options(function ($get) {
                        $kategoriId = $get('kategori_id'); // Ambil kategori yang dipilih
                        return $kategoriId
                            ? SubKategori::where('kategori_id', $kategoriId)->pluck('description', 'id')
                            : [];
                    })
                    ->required()
                    ->placeholder('Pilih subkategori'),
                // Forms\Components\Select::make('kategori_id')
                //     ->label('kategori')
                //     ->relationship('kategori', 'name') // Mengambil data dari relasi kecamatan
                //     ->required(),
                // Forms\Components\Select::make('sub_kategori_id')
                //     ->label('sub kategori')
                //     ->relationship('subkategori', 'description') // Mengambil data dari relasi kecamatan
                //     ->required(),
                Forms\Components\TextInput::make('name')
                ->label('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextArea::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->default('open')
                    ->maxLength(255)
                    ->readOnly(),
                Forms\Components\FileUpload::make('upload')
                ->label('upload file')
                ->disk('public')
                ->directory('pdfs')


                ->enableDownload()
                ->required()
                ->maxFiles(1)
                ->maxSize(2048)
                ->acceptedFileTypes(['application/pdf']),
                Forms\Components\Hidden::make('user_id')
            ->default(auth()->id()),

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor')
                ->label('Nomor tiket')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                ->label('Title')
                    ->searchable(),


                Tables\Columns\TextColumn::make('kategori.name')
                    ->searchable(),
                    // Tables\Columns\TextColumn::make('subkategori.description')
                    // ->searchable(),
                    Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->badge()
    ->color(fn (string $state): string => match ($state) {

       'open' => 'warning',
                        'resolved' => 'success',
                        'in_progress' => 'danger',
    }),
    Tables\Columns\TextColumn::make('description')
                ->label('Description')
                    ->searchable(),
                    Tables\Columns\ViewColumn::make('upload')
                ->label('upload file')
                ->view('components.pdf-preview')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('user.name')

                        ->searchable(),

            ])
            ->defaultGroup('status')
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ManageTikets::route('/'),
        ];
    }
}
