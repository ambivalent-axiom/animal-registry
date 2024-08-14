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




    Route::controller(FarmController::class)->group(function () {
        Route::get('/', 'index')
            ->name('farms.index');
        Route::get('/farms/index', 'index')
            ->name('farms.index');
        Route::get('/farms/show/{farm_id}', 'show')
            ->name('farms.show')
            ->middleware(IsFarmOwner::class);
        Route::get('/farms/create', 'create')
            ->name('farms.create');
        Route::post('/farms/create', 'store')
            ->name('farms.store');
        Route::delete('/farms/delete', 'destroy')
            ->name('farms.destroy')
            ->middleware(IsFarmOwner::class);
    });

    Route::controller(AnimalController::class)->group(function () {
        Route::get('/animals/update/{animal_id}', 'show')
            ->name('animals.update.show')
            ->middleware(IsAnimalOwner::class);
        Route::get('animals/create/{farm_id}', 'create')
            ->name('animals.create');
        Route::post('/animals/create', 'store')
            ->name('animals.store');
        Route::delete('/animals/delete', 'destroy')
            ->name('animals.destroy')
            ->middleware(IsAnimalOwner::class);
        Route::put('/animals/update', 'update')
            ->name('animals.update')
            ->middleware(IsAnimalOwner::class);
    });
});

require __DIR__.'/auth.php';
