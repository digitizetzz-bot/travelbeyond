<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        if (request()->user()?->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('app')->name('admin.')->group(function () {
    Route::livewire('dashboard', 'pages::admin.dashboard')->name('dashboard');
    Route::livewire('services', 'pages::admin.services')->name('services');
    Route::livewire('destinations', 'pages::admin.destinations.index')->name('destinations');
    Route::livewire('destinations/create', 'pages::admin.destinations.create')->name('destinations.create');
    Route::livewire('destinations/{destination}/edit', 'pages::admin.destinations.edit')->name('destinations.edit');
});

require __DIR__.'/settings.php';
