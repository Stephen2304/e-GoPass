<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PaiementController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\EGoPassController;
use App\Http\Controllers\Api\AbonneController;
use App\Http\Controllers\Api\VoyageurController;
use App\Http\Controllers\Api\AuthController;

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('paiements', PaiementController::class);
    Route::apiResource('transactions', TransactionController::class);
    Route::get('/download/paiements', [PaiementController::class, 'downloadPdf']);
});

Route::middleware(['auth:sanctum', 'role:super-admin'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::post('/egopass/generate', [EGoPassController::class, 'generate']);
    Route::apiResource('abonnes', AbonneController::class);
    Route::apiResource('voyageurs', VoyageurController::class);
    Route::get('/abonnes/{id}/download', [AbonneController::class, 'downloadPdf'])->name('abonnes.downloadPdf');
    Route::get('/voyageurs/{id}/download', [VoyageurController::class, 'downloadPdf'])->name('voyageurs.downloadPdf');
});


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/verify-token', [AuthController::class, 'verifyToken'])->name('auth.verifyToken');
});
