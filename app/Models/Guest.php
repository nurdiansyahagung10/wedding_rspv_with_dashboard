<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;



#[Fillable(['name', 'is_private_cat', 'is_attending', 'wishes', 'amount_of_guest', 'uuid', 'is_checked_in', 'checked_in_at'])]
class Guest extends Model
{
    protected function casts(): array
    {
        return [
            'is_checked_in' => 'boolean',
            'checked_in_at' => 'datetime',
        ];
    }
}
