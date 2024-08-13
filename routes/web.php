<?php

use App\Http\Controllers\Animal\AnimalController;
use App\Http\Controllers\Farm\FarmController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\IsAnimalOwner;
use App\Http\Middleware\IsFarmOwner;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/farms/index', [FarmController::class, 'index'])
        ->name('farms.index');
    Route::get('/farms/show/{farm_id}', [FarmController::class, 'show'])
        ->name('farms.show')
        ->middleware(IsFarmOwner::class);
    Route::get('/farms/create', [AnimalController::class, 'create'])
        ->name('farms.create');
    Route::post('/farms/create', [FarmController::class, 'store'])
        ->name('farms.store');

    Route::get('/animals/show/{animal_id}', [AnimalController::class, 'show'])
        ->name('animals.show')
        ->middleware(IsAnimalOwner::class);
    Route::get('animals/create', [AnimalController::class, 'create'])
        ->name('animals.create');
    Route::post('/animals/create', [AnimalController::class, 'store'])
        ->name('animal.store');


});

require __DIR__.'/auth.php';
