<?php

use App\Http\Controllers\HalamanController;
use Illuminate\Support\Facades\Route;

// Router: satu baris untuk satu halaman
Route::get('/', [HalamanController::class, 'home'])->name('home');
Route::get('/data-diri', [HalamanController::class, 'dataDiri'])->name('data-diri');
Route::get('/galeri', [HalamanController::class, 'galeri'])->name('galeri');
Route::get('/playlist', [HalamanController::class, 'playlist'])->name('playlist');
Route::get('/teman', [HalamanController::class, 'teman'])->name('teman');
