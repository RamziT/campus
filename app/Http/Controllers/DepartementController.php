<?php

// app/Http/Controllers/DepartementController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\UFR;
use App\Models\Universite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartementController extends Controller
{
    public function index()
    {
        $departements = Departement::with('ufr', 'filieres')->get();
        return view('departements.index', compact('departements'));
    }

    public function create()
    {
        $universites = Universite::where('statut', 'active')->orderBy('libelle', 'asc')->get();
        return view('departements.create', compact('universites'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ufr_id' => 'required|exists:ufr,id',
            'libelle' => 'required|string|max:255',
            'abreviation' => 'nullable|string|max:255',
            'responsable_id' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'statut' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $departement = new Departement();
        $departement->ufr_id = $request->input('ufr_id');
        $departement->libelle = $request->input('libelle');
        $departement->abreviation = $request->input('abreviation');
        $departement->responsable_id = $request->input('responsable_id');
        $departement->contact = $request->input('contact');
        $departement->email = $request->input('email');
        $departement->statut = $request->input('statut');
        $departement->created_by = 'system';
        $departement->save();

        return redirect()->route('departements.index')->with('success', 'Département créé avec succès');
    }

    public function show(Departement $departement)
    {
        return view('departements.show', compact('departement'));
    }

    public function edit(Departement $departement)
    {
        $universites = Universite::where('statut', 'active')->orderBy('libelle', 'asc')->get();
        return view('departements.edit', compact('departement', 'universites'));
    }

    public function update(Request $request, Departement $departement)
    {
        $validator = Validator::make($request->all(), [
            'ufr_id' => 'required|exists:ufr,id',
            'libelle' => 'required|string|max:255',
            'abreviation' => 'nullable|string|max:255',
            'responsable_id' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'statut' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $departement->ufr_id = $request->input('ufr_id');
        $departement->libelle = $request->input('libelle');
        $departement->abreviation = $request->input('abreviation');
        $departement->responsable_id = $request->input('responsable_id');
        $departement->contact = $request->input('contact');
        $departement->email = $request->input('email');
        $departement->statut = $request->input('statut');
        $departement->updated_by = 'system';
        $departement->save();

        return redirect()->route('departements.index')->with('success', 'Département mis à jour avec succès');
    }

    public function destroy(Departement $departement)
    {
        $departement->delete();
        return redirect()->route('departements.index')->with('success', 'Département supprimé avec succès');
    }
}
