<?php
namespace App\Filament\Widgets;

use App\Models\Guest;
use Filament\Widgets\ChartWidget;

class GuestLocationChart extends ChartWidget
{
    protected ?string $heading = 'Distribusi Tamu Hadir per Area';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $tenda = Guest::where('is_attending', true)->where('is_private_cat', true)->sum('amount_of_guest');
        $lantaiDua = Guest::where('is_attending', true)->where('is_private_cat', false)->sum('amount_of_guest');

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Orang (Pax)',
                    'data' => [$tenda, $lantaiDua],
                    'backgroundColor' => ['#d97706', '#2563eb'],
                ],
            ],
            'labels' => ['Area Tenda (Lantai Dasar)', 'Lantai 2 Gedung'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
