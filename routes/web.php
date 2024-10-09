<?php

use App\Http\Controllers\AccuracyController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestingDataController;
use App\Http\Controllers\TrainingCalculationController;
use App\Http\Controllers\TrainingDataController;
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
});

Route::controller(AttributeController::class)->prefix('attributes')->group(function(){
    Route::get('/', 'index')->name('attribute');
    Route::post('/', 'store')->name('attribute.store');
    Route::get('/{id}', 'show')->name('attribute.show');
    Route::put('/{id}/update', 'update')->name('attribute.update');
    Route::delete('/{id}/delete', 'destroy')->name('attribute.delete');
});
Route::controller(ClassController::class)->prefix('clases')->group(function(){
    Route::get('/', 'index')->name('class');
    Route::post('/', 'store')->name('class.store');
    Route::get('/{id}', 'show')->name('class.show');
    Route::put('/{id}/update', 'update')->name('class.update');
    Route::delete('/{id}/delete', 'destroy')->name('class.delete');
});
Route::controller(TrainingDataController::class)->prefix('training-data')->group(function(){
    Route::get('/', 'index')->name('training');
    Route::get('/create', 'create')->name('training.create');
    Route::post('/create', 'store')->name('training.store');
    Route::get('/{id}', 'show')->name('training.show');
    Route::put('/{id}/update', 'update')->name('training.update');
    Route::delete('/{id}/delete', 'destroy')->name('training.delete');
});
Route::controller(TestingDataController::class)->prefix('testing-data')->group(function(){
    Route::get('/', 'index')->name('testing');
    Route::get('/create', 'create')->name('testing.create');
    Route::post('/create', 'store')->name('testing.store');
    Route::get('/{id}', 'show')->name('testing.show');
    Route::put('/{id}/update', 'update')->name('testing.update');
    Route::delete('/{id}/delete', 'destroy')->name('testing.delete');
});

Route::controller(TrainingCalculationController::class)->prefix('probability-calculation')->group(function(){
    Route::get('/', 'index')->name('calculation.training');
    Route::post('/', 'store')->name('calculation.training.store');
});
Route::controller(AccuracyController::class)->prefix('accuracy-calculation')->group(function(){
    Route::get('/', 'index')->name('accuracy');
    Route::post('/', 'store')->name('accuracy.store');
});
require __DIR__.'/auth.php';
