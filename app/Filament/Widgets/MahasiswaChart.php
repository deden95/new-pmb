<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class MahasiswaChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Mahasiswa';
    protected static ?string $pollingInterval = null;
    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'bar'; // line, bar, pie, doughnut
    }

    protected function getData(): array
    {
        // Data mahasiswa aktif (status = 1)
        $activeData = Trend::query(User::where('status', 1)) // Perhatikan perubahan di sini
            ->between(
                start: now()->subMonths(12),
                end: now(),
            )
            ->perMonth()
            ->count(); // Hitung semua record
    
        // Data mahasiswa non-aktif (status = 0)
        $inactiveData = Trend::query(User::where('status', 0)) // Perhatikan perubahan di sini
            ->between(
                start: now()->subMonths(12),
                end: now(),
            )
            ->perMonth()
            ->count();
    
        return [
            'datasets' => [
                [
                    'label' => 'Mahasiswa Aktif',
                    'data' => $activeData->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => '#3B82F633',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Mahasiswa Non-Aktif',
                    'data' => $inactiveData->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#EF4444',
                    'backgroundColor' => '#EF444433',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $activeData->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Jumlah Mahasiswa'
                    ]
                ],
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Periode'
                    ]
                ]
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                    'labels' => [
                        'font' => [
                            'size' => 14
                        ]
                    ]
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) {
                            return context.dataset.label + ": " + context.parsed.y;
                        }'
                    ]
                ]
            ]
        ];
    }
}