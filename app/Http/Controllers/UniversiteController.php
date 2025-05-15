<?php

// app/Http/Controllers/UniversiteController.php

namespace App\Http\Controllers;

use App\Models\Universite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UniversiteController extends Controller
{
    /**
     * Affiche la liste des universités.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $universites = Universite::all();
        return view('universites.index', compact('universites'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle université.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('universites.create');
    }

    /**
     * Enregistre une nouvelle université dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'libelle' => 'required|string|max:255',
            'abreviation' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'site_web' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'statut' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create a new Universite instance and save it to the database
        $universite = new Universite();
        $universite->libelle = $request->input('libelle');
        $universite->abreviation = $request->input('abreviation');
        $universite->ville = $request->input('ville');
        $universite->telephone = $request->input('telephone');
        $universite->email = $request->input('email');
        $universite->site_web = $request->input('site_web');
        $universite->adresse = $request->input('adresse');
        $universite->statut = $request->input('statut');
        $universite->created_by = 'system'; // En attendant la gestion des utilisateurs
        $universite->save();
        return redirect()->route('universites.index')->with('success', 'Université créée avec succès');
    }

    /**
     * Affiche les détails d'une université.
     *
     * @param  \App\Models\Universite  $universite
     * @return \Illuminate\Http\Response
     */
    public function show(Universite $universite)
    {
        return view('universites.show', compact('universite'));
    }

    /**
     * Affiche le formulaire de modification d'une université.
     *
     * @param  \App\Models\Universite  $universite
     * @return \Illuminate\Http\Response
     */
    public function edit(Universite $universite)
    {
        return view('universites.edit', compact('universite'));
    }

    /**
     * Met à jour les informations d'une université dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Universite  $universite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Universite $universite)
    {
        $validator = Validator::make($request->all(), [
            'libelle' => 'required|string|max:255',
            'abreviation' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'site_web' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'statut' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $universite->libelle = $request->input('libelle');
        $universite->abreviation = $request->input('abreviation');
        $universite->ville = $request->input('ville');
        $universite->telephone = $request->input('telephone');
        $universite->email = $request->input('email');
        $universite->site_web = $request->input('site_web');
        $universite->adresse = $request->input('adresse');
        $universite->statut = $request->input('statut');
        $universite->updated_by = 'system'; // En attendant la gestion des utilisateurs
        $universite->save();
        return redirect()->route('universites.index')->with('success', 'Université mis à jour avec succès');
    }

    /**
     * Supprime une université de la base de données.
     *
     * @param  \App\Models\Universite  $universite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Universite $universite)
    {
        // $universite->deleted_by = 'system'; // En attendant la gestion des utilisateurs
        // $universite->save();

        $universite->delete();
        return redirect()->route('universites.index')->with('success', 'Université supprimée avec succès');
    }
}
