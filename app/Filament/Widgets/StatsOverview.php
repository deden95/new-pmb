<?php

namespace App\Filament\Widgets;

use App\Models\User; 
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Mahasiswa', User::count())
                ->icon('heroicon-o-users')
                ->description('Jumlah calon mahasiswa')
                ->color('success'),
                
            Stat::make('Mahasiswa Aktif', User::where('status', '1')->count())
                ->icon('heroicon-o-check-circle')
                ->description('Mahasiswa aktif')
                ->color('primary'),
                
            Stat::make('Mahasiswa Non Aktif', User::where('status', '0')->count())
                ->icon('heroicon-o-sparkles')
                ->description('Mahasiswa Belum Aktif')
                ->color('danger'),
        ];
    }
    
}