<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Tiket;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Illuminate\Database\Eloquent\Builder;

class RecentTiket extends BaseWidget
{


    protected static ?string $heading = 'Recent Tiket';
    protected static ?int $sort = 3; // Urutan di dashboard

    use HasWidgetShield;
    protected function getTableQuery(): Builder
    {
        // Mengembalikan query untuk tabel
        return Tiket::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('nomor')
                ->label('Judul')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('name')
                ->label('title')
                ->limit(50),
                Tables\Columns\TextColumn::make('user.name')
                ->label('user')
                ->limit(50),
            Tables\Columns\TextColumn::make('created_at')
                ->label('create')
                ->dateTime('d M Y, H:i')
                ->sortable(),
        ];
    }
}
