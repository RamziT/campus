<?php

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

// Universites routes
Route::prefix('universites')->group(function () {
    // Renvoie la liste de toutes les universités
    Route::get('/', function(Universite $universite) {
        return $universite->where('statut', 'active')->get();
    });

    // Renvoie une université par son ID
    Route::get('/{id}', function(Universite $universite, $id) {
        return $universite->where('id', $id)->where('statut', 'active')->get();
    });

    // Renvoie la liste des UFRs appartenant à une université
    Route::get('/{universite}/ufrs', function(Universite $universite) {
        return $universite->ufrs()->where('statut', 'active')->get();
    });

    // Renvoie la liste des départements appartenant à une université
    Route::get('/{universite}/departements', function(Universite $universite) {
        return $universite->departements()->where('statut', 'active')->get();
    });

    // Renvoie la liste des filières appartenant à une université
    Route::get('/{universite}/filieres', function(Universite $universite) {
        return $universite->filieres()->where('statut', 'active')->get();
    });

    // Renvoie la liste des niveaux appartenant à une université
    Route::get('/{universite}/niveaux', function(Universite $universite) {
        return $universite->niveaux()->where('statut', 'active')->get();
    });

    // Renvoie la liste des niveaux accessibles appartenant à une université
    Route::get('/{universite}/niveaux-accessibles', function(Universite $universite) {
        return $universite->niveaux()->where('statut', 'active')->where('accessible', true)->get();
    });
});

// UFRs routes
Route::prefix('ufrs')->group(function () {
    // Renvoie la liste de toutes les UFRs
    Route::get('/', function(UFR $ufr) {
        return $ufr->where('statut', 'active')->get();
    });

    // Renvoie une UFR par son ID
    Route::get('/{id}', function(UFR $ufr, $id) {
        return $ufr->where('id', $id)->where('statut', 'active')->get();
    });

    // Renvoie la liste des départements appartenant à une UFR
    Route::get('/{ufr}/departements', function(UFR $ufr) {
        return $ufr->departements()->where('statut', 'active')->get();
    });

    // Renvoie la liste des filières appartenant à une UFR
    Route::get('/{ufr}/filieres', function(UFR $ufr) {
        return $ufr->filieres()->where('statut', 'active')->get();
    });

    // Renvoie la liste des niveaux appartenant à une UFR
    Route::get('/{ufr}/niveaux', function(UFR $ufr) {
        return $ufr->niveaux()->where('statut', 'active')->get();
    });

    // Renvoie la liste des niveaux accessibles appartenant à une UFR
    Route::get('/{ufr}/niveaux-accessibles', function(UFR $ufr) {
        return $ufr->niveaux()->where('statut', 'active')->where('accessible', true)->get();
    });
});

// Departements routes
Route::prefix('departements')->group(function () {
    // Renvoie la liste de tous les départements
    Route::get('/', function(Departement $departement) {
        return $departement->where('statut', 'active')->get();
    });

    // Renvoie un département par son ID
    Route::get('/{id}', function(Departement $departement, $id) {
        return $departement->where('id', $id)->where('statut', 'active')->get();
    });

    // Renvoie la liste des filières appartenant à un département
    Route::get('/{departement}/filieres', function(Departement $departement) {
        return $departement->filieres()->where('statut', 'active')->get();
    });

    // Renvoie la liste des niveaux appartenant à un département
    Route::get('/{departement}/niveaux', function(Departement $departement) {
        return $departement->niveaux()->where('statut', 'active')->get();
    });

    // Renvoie la liste des niveaux accessibles appartenant à un département
    Route::get('/{departement}/niveaux-accessibles', function(Departement $departement) {
        return $departement->niveaux()->where('statut', 'active')->where('accessible', true)->get();
    });
});

// Filieres routes
Route::prefix('filieres')->group(function () {
    // Renvoie la liste de toutes les filières
    Route::get('/', function(Filiere $filiere) {
        return $filiere->where('statut', 'active')->get();
    });

    // Renvoie une filière par son ID
    Route::get('/{id}', function(Filiere $filiere, $id) {
        return $filiere->where('id', $id)->where('statut', 'active')->get();
    });

    // Renvoie la liste des niveaux appartenant à une filière
    Route::get('/{filiere}/niveaux', function(Filiere $filiere) {
        return $filiere->niveaux()->where('statut', 'active')->get();
    });

    // Renvoie la liste des niveaux accessibles appartenant à une filière
    Route::get('/{filiere}/niveaux-accessibles', function(Filiere $filiere) {
        return $filiere->niveaux()->where('statut', 'active')->where('accessible', true)->get();
    });

    // Renvoie la liste des diplômes appartenant à une filière
    Route::get('/{filiere}/diplomes', function(Filiere $filiere) {
        return $filiere->diplomes()->where('statut', 'active')->get();
    });
});

// Diplomes routes
Route::prefix('diplomes')->group(function () {
    // Renvoie la liste de tous les diplômes
    Route::get('/', function(Diplome $diplome) {
        return $diplome->where('statut', 'active')->get();
    });

    // Renvoie un diplôme par son ID
    Route::get('/{id}', function(Diplome $diplome, $id) {
        return $diplome->where('id', $id)->where('statut', 'active')->get();
    });
});

