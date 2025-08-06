<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Contracts\View\View;
use Filament\Notifications\Notification;
use App\Models\Tiket;
use App\Models\Comment;
use App\Models\Response;
use App\Models\User;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class CekTiket extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    use HasPageShield;

    protected static string $view = 'filament.pages.cek-tiket';
    public ?string $nomorTiket = null;
    public ?array $dataTiket = null;
    public ?array $comments = null;
    public ?array $responses = null;


    protected function getFormSchema(): array
    {
        return [




            Forms\Components\Section::make('Informasi Tiket')
                ->schema([
                    Forms\Components\TextInput::make('nomor')
                        ->label('Nomor Tiket')
                        ->disabled()
                        ->default(fn () => $this->dataTiket['nomor'] ?? null),
                    Forms\Components\TextInput::make('name')
                        ->label('Nama')
                        ->disabled()
                        ->default(fn () => $this->dataTiket['name'] ?? null),
                    Forms\Components\TextInput::make('status')
                        ->label('Status')
                        ->disabled()
                        ->default(fn () => $this->dataTiket['status'] ?? null),
                ])->hidden(fn () => !$this->dataTiket),

            Forms\Components\Section::make('Komentar dan Balasan')
                ->schema([
                    Forms\Components\Repeater::make('comments')
                        ->schema([
                            Forms\Components\TextInput::make('description')
                                ->label('Komentar')
                                ->disabled(),
                            Forms\Components\Repeater::make('responses')
                                ->schema([
                                    Forms\Components\TextArea::make('message')
                                        ->label('Balasan')
                                        ->disabled(),
                                    Forms\Components\FileUpload::make('upload')
                                        ->label('Lampiran Balasan')
                                        ->disabled()
                                        ->downloadable()
                                        ->visible(fn ($record) => !empty($record['upload'])),
                                ])->disableItemCreation(),
                        ])->disableItemCreation(),
                ])->hidden(fn () => !$this->comments),
        ];
    }


    public function cekTiket(): void
    {
        $tiket = Tiket::where('nomor', $this->nomorTiket)->first();

if ($tiket) {
    $this->dataTiket = $tiket->toArray();

    // Mengambil komentar dengan user yang membuatnya, serta respons
    $this->comments = Comment::where('tiket_id', $tiket->id)
        ->with(['responses.user', 'user', 'tiket']) // Tambahkan user di sini
        ->get()
        ->toArray();

    // Check if there are any responses
    $commentsWithResponses = array_filter($this->comments, function ($comment) {
        return !empty($comment['responses']); // If there are responses
    });

    if (empty($commentsWithResponses)) {
        // No responses found
        Notification::make()
            ->title('Tiket Ditemukan')
            ->body('Tiket ditemukan, tetapi belum ada respons.')
            ->info() // You can use info for this kind of notification
            ->send();
    } else {
        // Responses found
        Notification::make()
            ->title('Tiket Ditemukan')
            ->body('Informasi tiket dan komentar ditemukan, dengan respons ada.')
            ->success()
            ->send();
    }

} else {
    $this->dataTiket = null;
    $this->comments = null;
    Notification::make()
        ->title('Tiket Tidak Ditemukan')
        ->body('Nomor tiket yang Anda masukkan tidak ada.')
        ->danger()
        ->send();
}
    }


}
