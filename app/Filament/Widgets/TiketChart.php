<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Tiket;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Illuminate\Support\Facades\DB;

class TiketChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?int $sort = 2; // Urutan di dashboard

    use HasWidgetShield;

    protected function getData(): array
    {

        // Mengambil data jumlah tiket berdasarkan bulan
        $tiketData = Tiket::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Mengonversi data untuk digunakan dalam chart
        $labels = [];
        $data = [];

        foreach (range(1, 12) as $month) {
            $labels[] = date('M', mktime(0, 0, 0, $month, 1)); // Nama bulan
            $count = $tiketData->firstWhere('month', $month)->count ?? 0;
            $data[] = $count;
        }

        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [
                [
                    'label' => 'Jumlah Tiket',
                    'data' => $data,
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
        ];
    }


    protected function getType(): string
    {
        return 'line';
    }
}
