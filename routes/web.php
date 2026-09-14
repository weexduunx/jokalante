<?php

use App\Livewire\Journey;
use App\Livewire\TrainerDesk;
use Illuminate\Support\Facades\Route;

Route::get('/', Journey::class)->name('home');
Route::get('/formateur', TrainerDesk::class)->name('trainer');
