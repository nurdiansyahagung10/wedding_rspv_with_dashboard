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
                    ->required(),
                Toggle::make('is_private_cat')->columnSpanFull()
                    ->required(),
                Toggle::make('is_attending')->columnSpanFull()
                    ->required(),
                Toggle::make('has_answer')->columnSpanFull()
                    ->required(),
                TextInput::make('amount_of_guest')->columnSpanFull()
                    ->required()
                    ->numeric()
                    ->default(1),
                Textarea::make('wishes')
                    ->columnSpanFull(),
            ]);
    }
}
