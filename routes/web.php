<?php

use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

Route::get('rsvp/wishes', [GuestController::class, 'wishes'])->name('Guest.wishes');
Route::get('{uuid}', [GuestController::class, 'index'])->name('Guest.index');
Route::put('rsvp/guest/{id}/update', [GuestController::class, 'update'])->name('Guest.update');
