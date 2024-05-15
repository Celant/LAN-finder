<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Actions\ShowHome::class)->name('home');
Route::post('/', App\Actions\SearchPostcode::class)->name('search');
