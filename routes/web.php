<?php

use App\Http\Controllers\CNCSupplyController;
use App\Http\Controllers\CrisisStrickenController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\MachineManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimberSupplyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WoodManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('design/create/step1', [DesignController::class, 'create_step_1'])->name('design.create.step1');
    Route::post('design/store/step1', [DesignController::class, 'store_step_1'])->name('design.store.step1');
    Route::get('design/create/step2', [DesignController::class, 'create_step_2'])->name('design.create.step2');
    Route::post('design/store/step2', [DesignController::class, 'store_step_2'])->name('design.store.step2');
    Route::get('design/create/step3', [DesignController::class, 'create_step_3'])->name('design.create.step3');
    Route::post('design/store/step3', [DesignController::class, 'store_step_3'])->name('design.store.step3');
    Route::get('design/create/step4', [DesignController::class, 'create_step_4'])->name('design.create.step4');
    Route::post('design/store/step4', [DesignController::class, 'store_step_4'])->name('design.store.step4');
    Route::get('design/create/step5', [DesignController::class, 'create_step_5'])->name('design.create.step5');
    Route::post('design/store/step5', [DesignController::class, 'store_step_5'])->name('design.store.step5');
    Route::resource('design', DesignController::class)->except(['store', 'create']);
    Route::get('design/fork/{design_id}', [DesignController::class, 'fork'])->name('design.fork');

    Route::resource('timber-supply', TimberSupplyController::class)->except('show');

    Route::resource('cnc-supply', CNCSupplyController::class)->except('show');

    Route::get('shelter_seekers', [CrisisStrickenController::class, 'show'])->name('shelter_seekers');
    Route::post('shelter_seekers-suggest', [CrisisStrickenController::class, 'suggest'])->name('suggest');

    Route::apiResource('wood-management', WoodManagementController::class)->only('index', 'store', 'update', 'destroy');

    Route::middleware('is_admin')->group(function (){
        Route::get('user-management', [UserController::class, 'users_list'])->name('user-management');
    });
});

require __DIR__.'/auth.php';
