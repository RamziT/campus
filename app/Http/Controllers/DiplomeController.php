<?php

// app/Http/Controllers/DiplomeController.php

namespace App\Http\Controllers;

use App\Models\Diplome;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiplomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diplomes = Diplome::with('niveaux')->get();
        return view('diplomes.index', compact('diplomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $niveauxAccessibles = Niveau::where('accessible', 1)->where('statut', 'active')->get();
        return view('diplomes.create', compact('niveauxAccessibles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'libelle' => 'required|in:Baccaulérat,Licence,Licence Professionnelle,Master,Doctorant',
            'abreviation' => 'nullable',
            'serie' => 'nullable',
            'specialite' => 'nullable',
            'option' => 'nullable',
            'niveaux' => 'nullable|array',
            'niveaux.*' => 'exists:niveaux,id',
            'statut' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $diplome = new Diplome();
        $diplome->libelle = $request->input('libelle');
        $diplome->abreviation = $request->input('abreviation');
        $diplome->serie = $request->input('serie');
        $diplome->specialite = $request->input('specialite');
        $diplome->option = $request->input('option');
        $diplome->statut = $request->input('statut');
        $diplome->created_by = 'system'; // En attendant la gestion des utilisateurs
        $diplome->save();

        // Si des niveaux accessibles ont été sélectionnés
        if ($request->has('niveaux')) {
            $diplome->niveaux()->attach($request->niveaux, ['created_by' => 'system']);
        }

        return redirect()->route('diplomes.index')->with('success', 'Diplôme créé avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Diplome $diplome)
    {
        $diplome->load('niveaux');
        return view('diplomes.show', compact('diplome'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diplome $diplome)
    {
        $niveauxAccessibles = Niveau::where('accessible', 1)->where('statut', 'active')->get();
        $diplome->load('niveaux');
        return view('diplomes.edit', compact('diplome', 'niveauxAccessibles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diplome $diplome)
    {
        $validator = Validator::make($request->all(), [
            'libelle' => 'required|in:Baccaulérat,Licence,Licence Professionnelle,Master,Doctorant',
            'abreviation' => 'nullable',
            'serie' => 'nullable',
            'spécialite' => 'nullable',
            'option' => 'nullable',
            'niveaux' => 'nullable|array',
            'niveaux.*' => 'exists:niveaux,id',
            'statut' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $diplome->libelle = $request->input('libelle');
        $diplome->abreviation = $request->input('abreviation');
        $diplome->serie = $request->input('serie');
        $diplome->specialite = $request->input('specialite');
        $diplome->option = $request->input('option');
        $diplome->statut = $request->input('statut');
        $diplome->updated_by = 'system'; // En attendant la gestion des utilisateurs
        $diplome->save();

        // Détacher tous les niveaux existants
        $diplome->niveaux()->detach();

        // Si des niveaux accessibles ont été sélectionnés
        if ($request->has('niveaux')) {
            $diplome->niveaux()->attach($request->niveaux, ['created_by' => 'system']);
        }

        return redirect()->route('diplomes.index')->with('success', 'Diplôme mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diplome $diplome)
    {
        $diplome->delete();
        return redirect()->route('diplomes.index')->with('success', 'Diplôme supprimé avec succès!');
    }
}
