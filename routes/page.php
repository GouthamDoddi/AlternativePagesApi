<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::prefix('page')->group(function () {
    Route::get('/', [PageController::class, 'index'])->name('pages.index');
    Route::get('/{id}', [PageController::class, 'show'])->name('pages.show');
    Route::post('/', [PageController::class, 'store'])->name('pages.store');
    Route::put('/{id}', [PageController::class, 'update'])->name('pages.update');
    Route::delete('/{id}', [PageController::class, 'destroy'])->name('pages.destroy');
});
