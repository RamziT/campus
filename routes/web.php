<?php

use App\Http\Controllers\DepartementController;
use App\Http\Controllers\DiplomeController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NiveauController;
use App\Http\Controllers\UfrController;
use App\Http\Controllers\UniversiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('universites', UniversiteController::class);
Route::resource('ufrs', UfrController::class);
Route::resource('departements', DepartementController::class);
Route::resource('filieres', FiliereController::class);
Route::resource('niveaux', NiveauController::class);
Route::resource('diplomes', DiplomeController::class);
