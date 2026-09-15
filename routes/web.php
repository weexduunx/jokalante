<?php

use App\Livewire\Dashboard;
use App\Livewire\Journey;
use App\Livewire\TrainerDesk;
use Illuminate\Support\Facades\Route;

Route::get('/', Journey::class)->name('home');
Route::get('/mon-parcours', Dashboard::class)->name('dashboard');
Route::get('/formateur', TrainerDesk::class)->name('trainer');
