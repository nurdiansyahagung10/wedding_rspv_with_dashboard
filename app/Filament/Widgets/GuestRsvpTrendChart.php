<?php

namespace App\Filament\Widgets;

use App\Models\Guest;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class GuestRsvpTrendChart extends ChartWidget
{
    protected ?string $heading = 'Tren Konfirmasi RSVP (7 Hari Terakhir)';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        // Mengelompokkan data konfirmasi 7 hari terakhir
        $days = collect(range(6, 0))->map(fn ($i) => Carbon::today()->subDays($i)->format('Y-m-d'));

        $hadirCounts = [];
        $tidakHadirCounts = [];

        foreach ($days as $day) {
            $hadirCounts[] = Guest::where('has_answer', true)
                ->where('is_attending', 'yes')
                ->whereDate('updated_at', $day)
                ->count();

            $tidakHadirCounts[] = Guest::where('has_answer', true)
                ->where('is_attending', 'no')
                ->whereDate('updated_at', $day)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Konfirmasi Hadir',
                    'data' => $hadirCounts,
                    'borderColor' => '#16a34a', // Hijau
                    'backgroundColor' => 'rgba(22, 163, 74, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
                [
                    'label' => 'Berhalangan Hadir',
                    'data' => $tidakHadirCounts,
                    'borderColor' => '#dc2626', // Merah
                    'backgroundColor' => 'rgba(220, 38, 38, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $days->map(fn ($d) => Carbon::parse($d)->translatedFormat('d M'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}