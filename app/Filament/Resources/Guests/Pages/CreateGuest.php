<?php

namespace App\Filament\Resources\Guests\Pages;

use App\Filament\Resources\Guests\GuestResource;
use App\Models\Guest;
use Filament\Resources\Pages\CreateRecord;
use Hash;
use Illuminate\Database\Eloquent\Model;
use Str;

class CreateGuest extends CreateRecord
{
    protected static string $resource = GuestResource::class;


    protected function handleRecordCreation(array $data): Model
    {
        $product = Guest::create([
            'name' => $data['name'],
            'is_attending' => $data['is_attending'],
            'is_private_cat' => $data['is_private_cat'],
            'has_answer' => $data['has_answer'],
            'amount_of_guest' => $data['amount_of_guest'],
            'uuid' => Str::uuid()->toString(),
        ]);

        return $product;
    }
}
