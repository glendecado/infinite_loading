<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'list-users');


Route::get('/blade', [UserController::class, 'index'])->name('blade-users.index');

