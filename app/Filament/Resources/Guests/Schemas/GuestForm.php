<?php

namespace App\Filament\Resources\Guests\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GuestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->columnSpanFull()
                    ->disabled(fn () => auth()->user()->isStaff())
                    ->required(),
                Toggle::make('is_private_cat')->columnSpanFull()
                    ->disabled(fn () => auth()->user()->isStaff()),
                Toggle::make('is_attending')->columnSpanFull(),
                Toggle::make('has_answer')->columnSpanFull(),
                TextInput::make('amount_of_guest')->columnSpanFull()
                    ->numeric()
                    ->default(1),
                Textarea::make('wishes')
                    ->columnSpanFull(),
            ]);
    }
}
