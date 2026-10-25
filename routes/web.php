<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\LocationController;

Route::get('/', [FamilyController::class, 'index']);

Route::get('/families', [FamilyController::class, 'index'])
    ->name('families.index');

Route::get('/families/create', [FamilyController::class, 'create'])
    ->name('families.create');

Route::post('/families', [FamilyController::class, 'store'])
    ->name('families.store');

Route::get('/families/{familyHead}', [FamilyController::class, 'show'])
    ->name('families.show');

Route::get('/locations/cities', [LocationController::class, 'cities'])
    ->name('locations.cities');
