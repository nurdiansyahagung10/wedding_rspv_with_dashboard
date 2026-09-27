<?php

namespace App\Filament\Widgets;

use App\Models\Guest;
use Filament\Widgets\ChartWidget;

class GuestCategoryBreakdownChart extends ChartWidget
{
    protected ?string $heading = 'Undangan vs Pax Hadir per Kelompok';
    protected static ?int $sort = 4;

        protected int | string | array $columnSpan = 'full'; // Membentang lebar di layar


    protected function getData(): array
    {
        $categories = ['Nasional Umum', 'Nasional Tamu Pengantin'];

        $invitationCounts = [];
        $paxCounts = [];

        foreach ($categories as $cat) {
            // Jumlah undangan (kartu/kepala keluarga) yang hadir
            $invitationCounts[] = Guest::where('is_attending', 'yes')
                ->where('is_private_cat', $cat)
                ->count();

            // Total jumlah orang yang dibawa
            $paxCounts[] = (int) Guest::where('is_attending', 'yes')
                ->where('is_private_cat', $cat)
                ->sum('amount_of_guest');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Undangan (Form)',
                    'data' => $invitationCounts,
                    'backgroundColor' => '#f59e0b', // Amber / Gold
                ],
                [
                    'label' => 'Total Fisik Orang (Pax)',
                    'data' => $paxCounts,
                    'backgroundColor' => '#6366f1', // Indigo
                ],
            ],
            'labels' => ['Keluarga KSP / Umum', 'Teman & Kolega Pengantin'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}