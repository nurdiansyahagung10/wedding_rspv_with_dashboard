<?php

namespace App\Filament\Resources\Guests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

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
                    
                TextColumn::make('amount_of_guest')
                    ->label('Pax')
                    ->alignCenter()
                    ->sortable()
                    ->default('-'),

                TextColumn::make('is_private_cat')
                    ->label('Lokasi Duduk')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Area Tenda (Lt. Dasar)' : 'Lantai 2 Gedung')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'warning' : 'info'),

                TextColumn::make('wishes')
                    ->label('Ucapan & Doa')
                    ->limit(35)
                    ->tooltip(fn ($record): ?string => $record->wishes)
                    ->toggleable(isToggledHiddenByDefault: false) ->default('-'),
                
                TextColumn::make('url')
                    ->label('URL')
                    ->state(function ($record) {
                            return env('APP_DOMAIN_URL') . '/'. $record->uuid;
                        })    ->copyable()
            ])
            ->filters([
                TernaryFilter::make('has_answer')
                    ->label('Sudah RSVP'),

                SelectFilter::make('is_attending')
                    ->label('Status Hadir')
                    ->options([
                        'yes' => 'Hadir',
                        'no' => 'Tidak Hadir',
                    ]),

                SelectFilter::make('is_private_cat')
                    ->label('Lokasi Resepsi')
                    ->options([
                        1 => 'Area Tenda (Lt. Dasar)',
                        0 => 'Lantai 2 Gedung',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
