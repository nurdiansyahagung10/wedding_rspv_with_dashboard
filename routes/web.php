<?php

use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

Route::get('{uuid}', [GuestController::class, 'index'])->name('guest.index');
Route::put('rsvp/guest/{id}/update', [GuestController::class, 'update'])->name('guest.update');
