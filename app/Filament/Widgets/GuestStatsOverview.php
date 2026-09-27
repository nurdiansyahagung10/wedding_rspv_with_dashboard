<?php

namespace App\Filament\Widgets;

use App\Models\Guest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GuestStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalUndangan = Guest::count();
        $sudahKonfirmasi = Guest::where('has_answer', true)->count();
        $akanHadir = Guest::where('has_answer', true)->where('is_attending', 'yes')->count();
        $tidakHadir = Guest::where('has_answer', true)->where('is_attending', 'no')->count();
        
        // Total pax fisik yang akan hadir
        $totalPax = Guest::where('has_answer', true)
            ->where('is_attending', 'yes')
            ->sum('amount_of_guest');

        return [
            Stat::make('Total Undangan', $totalUndangan)
                ->description("Sudah konfirmasi: {$sudahKonfirmasi}")
                ->icon('heroicon-o-envelope'),

            Stat::make('Konfirmasi Hadir', $akanHadir)
                ->description("Estimasi: {$totalPax} Pax/Orang")
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            Stat::make('Tidak Hadir', $tidakHadir)
                ->description('Berhalangan hadir')
                ->color('danger')
                ->icon('heroicon-o-x-circle'),

            Stat::make('Belum Menjawab', $totalUndangan - $sudahKonfirmasi)
                ->description('Menunggu respons')
                ->color('warning')
                ->icon('heroicon-o-clock'),
        ];
    }
}