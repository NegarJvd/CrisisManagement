<?php

use App\Http\Controllers\CNCSupplyController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimberSupplyController;
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

    Route::resource('design', DesignController::class)->except('show');
    Route::get('design/delete_file/{design_id}', [DesignController::class, 'delete_file'])->name('design.delete_file');
    Route::get('design/download_file/{design_id}', [DesignController::class, 'download_file'])->name('design.download_file');

    Route::resource('timber-supply', TimberSupplyController::class)->except('show');
    Route::resource('cnc-supply', CNCSupplyController::class)->except('show');

});

require __DIR__.'/auth.php';
