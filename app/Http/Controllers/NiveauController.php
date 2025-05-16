<?php

// app/Http/Controllers/NiveauController.php

namespace App\Http\Controllers;

use App\Models\Diplome;
use App\Models\Filiere;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NiveauController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $niveaux = Niveau::with('filiere')->get();
        return view('niveaux.index', compact('niveaux'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filieres = Filiere::all();
        $diplomes = Diplome::where('statut', 'active')->get();
        return view('niveaux.create', compact('filieres', 'diplomes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'libelle' => 'required|in:Licence 1,Licence 2,Licence 3,Master 1,Master 2,Doctorat 1,Doctorat 2,Doctorat 3',
            'abreviation' => 'nullable|in:L1,L2,L3,M1,M2,D1,D2,D3',
            'filiere_id' => 'required|exists:filieres,id',
            'accessible' => 'boolean',
            'diplomes' => 'nullable|array',
            'diplomes.*' => 'exists:diplomes,id',
            'statut' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $niveau = new Niveau();
        $niveau->libelle = $request->input('libelle');
        $niveau->abreviation = $request->input('abreviation');
        $niveau->filiere_id = $request->input('filiere_id');
        $niveau->accessible = $request->has('accessible') ? 1 : 0;
        $niveau->statut = $request->input('statut');
        $niveau->created_by = 'system'; // En attendant la gestion des utilisateurs
        $niveau->save();

        // Si le niveau est accessible et que des diplômes ont été sélectionnés
        if ($niveau->accessible && $request->has('diplomes')) {
            $niveau->diplomes()->attach($request->diplomes, ['created_by' => 'system']);
        }

        return redirect()->route('niveaux.index')->with('success', 'Niveau créé avec succès!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Niveau $niveau)
    {
        $niveau->load('diplomes');
        return view('niveaux.show', compact('niveau'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Niveau $niveau)
    {
        $filieres = Filiere::all();
        $diplomes = Diplome::where('statut', 'active')->get();
        $niveau->load('diplomes');
        return view('niveaux.edit', compact('niveau', 'filieres', 'diplomes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Niveau $niveau)
    {
        $validator = Validator::make($request->all(), [
            'libelle' => 'required|in:Licence 1,Licence 2,Licence 3,Master 1,Master 2,Doctorat 1,Doctorat 2,Doctorat 3',
            'abreviation' => 'nullable|in:L1,L2,L3,M1,M2,D1,D2,D3',
            'filiere_id' => 'required|exists:filieres,id',
            'accessible' => 'boolean',
            'diplomes' => 'nullable|array',
            'diplomes.*' => 'exists:diplomes,id',
            'statut' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $niveau->libelle = $request->input('libelle');
        $niveau->abreviation = $request->input('abreviation');
        $niveau->filiere_id = $request->input('filiere_id');
        $niveau->accessible = $request->has('accessible') ? 1 : 0;
        $niveau->statut = $request->input('statut');
        $niveau->updated_by = 'system'; // En attendant la gestion des utilisateurs
        $niveau->save();

        // Détacher tous les diplômes existants
        $niveau->diplomes()->detach();

        // Si le niveau est accessible et que des diplômes ont été sélectionnés
        if ($niveau->accessible && $request->has('diplomes')) {
            $niveau->diplomes()->attach($request->diplomes, ['created_by' => 'system']);
        }

        return redirect()->route('niveaux.index')->with('success', 'Niveau mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Niveau $niveau)
    {
        $niveau->delete();
        return redirect()->route('niveaux.index')->with('success', 'Niveau supprimé avec succès!');
    }
}
