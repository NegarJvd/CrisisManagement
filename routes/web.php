<?php

use App\Http\Controllers\CNCSupplyController;
use App\Http\Controllers\CrisisStrickenController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\OrderController;
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
    Route::prefix('profile')->name('profile.')->group(function (){
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::resource('/design', DesignController::class)->only(['index', 'show', 'destroy']);
    Route::prefix('design')->name('design.')->group(function (){
        Route::get('/fork/{design_id}', [DesignController::class, 'fork'])->name('fork');

        Route::prefix('create')->name('create.')->group(function (){
            Route::get('/step1', [DesignController::class, 'create_step_1'])->name('step1');
            Route::get('/step2', [DesignController::class, 'create_step_2'])->name('step2');
            Route::get('/step3', [DesignController::class, 'create_step_3'])->name('step3');
            Route::get('/step4', [DesignController::class, 'create_step_4'])->name('step4');
            Route::get('/step5', [DesignController::class, 'create_step_5'])->name('step5');
        });

        Route::prefix('store')->name('store.')->group(function (){
            Route::post('/step1', [DesignController::class, 'store_step_1'])->name('step1');
            Route::post('/step2', [DesignController::class, 'store_step_2'])->name('step2');
            Route::post('/step3', [DesignController::class, 'store_step_3'])->name('step3');
            Route::post('/step4', [DesignController::class, 'store_step_4'])->name('step4');
            Route::post('/step5', [DesignController::class, 'store_step_5'])->name('step5');
        });
    });

    Route::resource('timber-provider', TimberSupplyController::class)->except('show');
    Route::get('/timber-provider/orders', [OrderController::class, 'timber_orders'])->name('timber-provider.order');

    Route::resource('cnc-provider', CNCSupplyController::class)->except('show');
    Route::get('/cnc-provider/orders', [OrderController::class, 'cnc_orders'])->name('cnc-provider.order');

    Route::resource('wood-management', WoodManagementController::class);

    Route::prefix('shelter_seekers')->name('shelter_seekers.')->group(function (){
        Route::get('/', [CrisisStrickenController::class, 'show'])->name('show');
        Route::post('/providers', [CrisisStrickenController::class, 'providers_list'])->name('providers_list');
    });
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');

    Route::middleware('is_admin')->group(function (){
        Route::get('user-management', [UserController::class, 'users_list'])->name('user-management');
    });

});

require __DIR__.'/auth.php';
