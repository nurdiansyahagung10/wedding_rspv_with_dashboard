<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;



#[Fillable(['name', 'is_private_cat', 'is_attending', 'wishes', 'amount_of_guest', 'uuid'])]
class Guest extends Model
{

}
