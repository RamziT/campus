<?php

use App\Http\Controllers\ApiDepartementController;
use App\Http\Controllers\ApiDiplomeController;
use App\Http\Controllers\ApiFiliereController;
use App\Http\Controllers\ApiNiveauController;
use App\Http\Controllers\ApiUfrController;
use App\Http\Controllers\ApiUniversiteController;
use App\Models\Departement;
use App\Models\Diplome;
use App\Models\Filiere;
use App\Models\UFR;
use App\Models\Universite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// User route
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Universités routes
Route::prefix('universites')->group(function () {
    Route::get('/', [ApiUniversiteController::class, 'index']);
    Route::get('/{id}', [ApiUniversiteController::class, 'show']);
    Route::get('/{universite}/ufrs', [ApiUniversiteController::class, 'getUfrs']);
    Route::get('/{universite}/departements', [ApiUniversiteController::class, 'getDepartements']);
    Route::get('/{universite}/filieres', [ApiUniversiteController::class, 'getFilieres']);
    Route::get('/{universite}/niveaux', [ApiUniversiteController::class, 'getNiveaux']);
    Route::get('/{universite}/niveaux-accessibles', [ApiUniversiteController::class, 'getNiveauxAccessibles']);
});

// UFR routes
Route::prefix('ufrs')->group(function () {
    Route::get('/', [ApiUfrController::class, 'index']);
    Route::get('/{id}', [ApiUfrController::class, 'show']);
    Route::get('/{ufr}/departements', [ApiUfrController::class, 'getDepartements']);
    Route::get('/{ufr}/filieres', [ApiUfrController::class, 'getFilieres']);
    Route::get('/{ufr}/niveaux', [ApiUfrController::class, 'getNiveaux']);
    Route::get('/{ufr}/niveaux-accessibles', [ApiUfrController::class, 'getNiveauxAccessibles']);
});

// Départements routes
Route::prefix('departements')->group(function () {
    Route::get('/', [ApiDepartementController::class, 'index']);
    Route::get('/{id}', [ApiDepartementController::class, 'show']);
    Route::get('/{departement}/filieres', [ApiDepartementController::class, 'getFilieres']);
    Route::get('/{departement}/niveaux', [ApiDepartementController::class, 'getNiveaux']);
    Route::get('/{departement}/niveaux-accessibles', [ApiDepartementController::class, 'getNiveauxAccessibles']);
});

// Filieres routes
Route::prefix('filieres')->group(function () {
    Route::get('/', [ApiFiliereController::class, 'index']);
    Route::get('/{id}', [ApiFiliereController::class, 'show']);
    Route::get('/{filiere}/niveaux', [ApiFiliereController::class, 'getNiveaux']);
    Route::get('/{filiere}/niveaux-accessibles', [ApiFiliereController::class, 'getNiveauxAccessibles']);
    Route::get('/{filiere}/diplomes', [ApiFiliereController::class, 'getDiplomes']);
});

// Routes pour les Niveaux
Route::prefix('niveaux')->group(function () {
    // Récupérer tous les niveaux
    Route::get('/', [ApiNiveauController::class, 'index']);

    // Récupérer les niveaux accessibles
    Route::get('/accessibles', [ApiNiveauController::class, 'getAccessibles']);

    // Récupérer les niveaux d'une filière
    Route::get('/filiere/{filiere_id}', [ApiNiveauController::class, 'getByFiliere']);

    // Récupérer un niveau par son ID
    Route::get('/{id}', [ApiNiveauController::class, 'show']);

    // Récupérer les diplômes requis pour un niveau
    Route::get('/{niveau}/diplomes', [ApiNiveauController::class, 'getDiplomes']);
});

// Routes pour les Diplômes
Route::prefix('diplomes')->group(function () {
    // Récupérer tous les diplômes
    Route::get('/', [ApiDiplomeController::class, 'index']);

    // Récupérer les diplômes par type
    Route::get('/types/{type}', [ApiDiplomeController::class, 'getByType']);

    // Récupérer un diplôme par son ID
    Route::get('/{id}', [ApiDiplomeController::class, 'show']);

    // Récupérer les filières accessibles avec un diplôme
    Route::get('/{diplome}/filieres', [ApiDiplomeController::class, 'getFilieresAccessibles']);

    // Récupérer les niveaux accessibles avec un diplôme
    Route::get('/{diplome}/niveaux', [ApiDiplomeController::class, 'getNiveaux']);
});

// Route spéciale pour les baccalauréats
Route::get('baccalaureats', [ApiDiplomeController::class, 'getBaccalaureats']);

// Route pour toutes les filieres accessibles et leurs diplomes correspondants
Route::get('/niveaux-accessibles', [ApiNiveauController::class, 'getAllNiveauxAccessibles']);
