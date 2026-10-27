<?php

namespace App\Filament\Resources\Guests\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class GuestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Tamu')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                IconColumn::make('is_attending')
                    ->boolean(),
                IconColumn::make('has_answer')
                    ->label('has_answer')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('gray'),

                IconColumn::make('is_checked_in')
                    ->label('Check-in')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-minus-circle')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->tooltip(fn ($record): ?string => $record->checked_in_at
                        ? 'Hadir pada '.$record->checked_in_at->format('d M Y H:i')
                        : null),

                TextColumn::make('amount_of_guest')
                    ->label('Pax')
                    ->alignCenter()
                    ->sortable()
                    ->default('-'),

                TextColumn::make('is_private_cat')
                    ->label('Lokasi Duduk')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Lantai 2 Gedung' : 'Area Tenda (Lt. Dasar)')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'warning' : 'info'),

                TextColumn::make('wishes')
                    ->label('Ucapan & Doa')
                    ->limit(35)
                    ->tooltip(fn ($record): ?string => $record->wishes)
                    ->toggleable(isToggledHiddenByDefault: false)->default('-'),

                TextColumn::make('copy_invitation')
                    ->label('Pesan Undangan')
                    ->state(fn () => 'Salin Undangan')
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->copyable()
                    ->copyableState(function ($record) {
                        $domain = env('APP_DOMAIN_URL') ?: url('/');
                        $url = rtrim($domain, '/').'/'.$record->uuid;

                        return "Salam Damai Sejahtera.\n\n"
                            ."Yth. *{$record->name}*\n\n"
                            ."Kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat untuk dapat hadir merayakan kebahagiaan pernikahan kami yang akan dilaksanakan pada:\n\n"
                            ."📅 : Sabtu, 12 Desember 2026\n"
                            ."⏰ : *09.00 - 10.00* WIB ( Pemberkatan )\n"
                            ."📍 : GKI BaJem Kawaluyaan Maulana Yusuf\n"
                            ."⏰ : 10.00 WIB - ( Resepsi Adat )\n"
                            ."📍 : GSG Maduma Naramamora\n\n"
                            ."Panduan informasi dan lokasi acara lengkap dapat mengunjungi link berikut:\n\n"
                            ."{$url}\n\n"
                            ."Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i, berkenan untuk hadir merayakan momen bahagia kami dan memberikan doa restu.\n\n"
                            ."Mohon maaf perihal undangan hanya dibagikan melalui pesan ini. Terima kasih atas perhatiannya.\n\n"
                            ."Kami yang berbahagia,\n"
                            ."*Christy & Gideon*";
                    })
                    ->copyMessage('Pesan undangan berhasil disalin')
                    ->copyMessageDuration(2000)
                    ->visible(fn () => ! auth()->user()->isStaff())
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('url')
                    ->label('URL')
                    ->state(function ($record) {
                        return (env('APP_DOMAIN_URL') ?: url('/')).'/'.$record->uuid;
                    })->copyable()
                    ->visible(fn () => ! auth()->user()->isStaff())
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
              TernaryFilter::make('has_answer')
                  ->label('Sudah RSVP'),

              TernaryFilter::make('is_checked_in')
                  ->label('Sudah Check-in'),

              SelectFilter::make('is_attending')
                  ->label('Status Hadir')
                  ->options([
                    'yes' => 'Hadir',
                    'no' => 'Tidak Hadir',
                  ]),

              SelectFilter::make('is_private_cat')
                  ->label('Lokasi Resepsi')
                  ->options([
                    1 => 'Lantai 2 Gedung',
                    0 => 'Area Tenda (Lt. Dasar)',
                  ]),
          ])
            ->actions([
              Action::make('confirmAttendance')
                  ->label('Konfirmasi Hadir')
                  ->icon('heroicon-o-check-badge')
                  ->color('success')
                  ->visible(fn ($record) => ! $record->is_checked_in)
                  ->action(fn ($record) => $record->update([
                    'is_checked_in' => true,
                    'checked_in_at' => now(),
                  ])),
              Action::make('cancelAttendance')
                  ->label('Batalkan Check-in')
                  ->icon('heroicon-o-x-mark')
                  ->color('gray')
                  ->requiresConfirmation()
                  ->visible(fn ($record) => $record->is_checked_in)
                  ->action(fn ($record) => $record->update([
                    'is_checked_in' => false,
                    'checked_in_at' => null,
                  ])),
              EditAction::make(),
              DeleteAction::make()->visible(fn () => ! auth()->user()->isStaff()),
          ])
            ->bulkActions([
              BulkActionGroup::make([
                  BulkAction::make('bulkConfirmAttendance')
                    ->label('Konfirmasi Hadir')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi kehadiran tamu terpilih?')
                    ->action(fn (Collection $records) => $records
                        ->where('is_checked_in', false)
                        ->each->update(['is_checked_in' => true, 'checked_in_at' => now()]))
                    ->deselectRecordsAfterCompletion(),
                  BulkAction::make('bulkCancelAttendance')
                    ->label('Batalkan Check-in')
                    ->icon('heroicon-o-x-mark')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records
                        ->each->update(['is_checked_in' => false, 'checked_in_at' => null]))
                    ->deselectRecordsAfterCompletion(),
                  DeleteBulkAction::make()->visible(fn () => ! auth()->user()->isStaff()),
              ]),
          ]);
    }
}
