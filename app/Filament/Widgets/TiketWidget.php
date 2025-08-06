<?php

namespace App\Filament\Widgets;

use App\Models\Response;
use App\Models\Tiket;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Support\Enums\IconPosition;

class TiketWidget extends BaseWidget

{
    protected static ?int $sort = 1; // Urutan di dashboard

    use HasWidgetShield;

    protected function getStats(): array
    {

        return [
            Stat::make('Tiket',(Tiket::count('nomor')))
            ->description('Total Tiket')
            ->descriptionIcon('heroicon-m-inbox-arrow-down', IconPosition::Before)
            ->chart([1, 3, 5, 10, 20, 10])
            ->color('info'),
            Stat::make('Response',(Response::count('comment_id')))
            ->description('Total Respone')
            ->descriptionIcon('heroicon-m-inbox-arrow-down', IconPosition::Before)
            ->chart([1, 3, 5, 10, 20, 10])
            ->color('success'),


        ];
    }
}
