<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'list-users');

// SAMPLE ONLY — dapat ibutang sa api.php kung real API
Route::get('/users', function () {
    $page = (int) request('page', 1);
    $perPage = (int) request('perPage', 7);

    $total = User::count();

    $skip = ($page - 1) * $perPage;

    // main query
    $users = User::skip($skip)
        ->take($perPage)
        ->get(['id', 'name', 'email']); // limit fields (faster)

    return response()->json([
        'data'    => $users,
        'total'   => $total,
        'hasMore' => $skip + $perPage < $total,
    ]);
});

Route::view('/blade', 'blade.list-users');
