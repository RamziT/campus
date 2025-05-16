<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Niveau;
use App\Models\Departement;
use App\Models\Diplome;
use App\Models\Universite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class FiliereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filieres = Filiere::with('departement')->get();
        return view('filieres.index', compact('filieres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $universites = Universite::where('statut', 'active')->orderBy('libelle')->get();
        $diplomes = Diplome::orderBy('libelle')->where('statut', 'active')->get();
        return view('filieres.create', compact('universites', 'diplomes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'libelle' => 'required|string',
            'abreviation' => 'nullable|string',
            'departement_id' => 'required|exists:departements,id',
            'statut' => 'required|string|in:active,inactive',
            'niveaux' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Créer la filière
            $filiere = new Filiere();
            $filiere->libelle = $request->input('libelle');
            $filiere->abreviation = $request->input('abreviation');
            $filiere->departement_id = $request->input('departement_id');
            $filiere->statut = $request->input('statut');
            $filiere->created_by = 'system'; // En attendant la gestion des utilisateurs
            $filiere->save();

            // Traiter les niveaux
            if ($request->has('niveaux')) {
                foreach ($request->niveaux as $key => $niveauData) {
                    // Vérifier si le niveau est actif
                    if (isset($niveauData['active'])) {
                        $niveau = new Niveau();
                        $niveau->libelle = $niveauData['libelle'];
                        $niveau->abreviation = $niveauData['abreviation'];
                        $niveau->filiere_id = $filiere->id;
                        $niveau->accessible = isset($niveauData['accessible']) ? 1 : 0;
                        $niveau->statut = $niveauData['statut'] ?? 'active';
                        $niveau->created_by = 'system';
                        $niveau->save();

                        // Si le niveau est accessible et que des diplômes ont été sélectionnés
                        if ($niveau->accessible && isset($niveauData['diplomes'])) {
                            $niveau->diplomes()->attach($niveauData['diplomes'], ['created_by' => 'system']);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('filieres.index')->with('success', 'Filière créée avec succès!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création de la filière: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Filiere $filiere)
    {
        $filiere->load('niveaux.diplomes', 'departement');
        return view('filieres.show', compact('filiere'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Filiere $filiere)
    {
        $universites = Universite::where('statut', 'active')->orderBy('libelle')->get();
        $diplomes = Diplome::where('statut', 'active')->orderBy('libelle')->get();
        $filiere->load('niveaux.diplomes');
        return view('filieres.edit', compact('filiere', 'universites', 'diplomes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Filiere $filiere)
    {
        $validator = Validator::make($request->all(), [
            'libelle' => 'required|string',
            'abreviation' => 'nullable|string',
            'departement_id' => 'required|exists:departements,id',
            'statut' => 'required|string|in:active,inactive',
            'niveaux' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Mettre à jour la filière
            $filiere->libelle = $request->libelle;
            $filiere->abreviation = $request->abreviation;
            $filiere->departement_id = $request->departement_id;
            $filiere->statut = $request->statut;
            $filiere->updated_by = 'system'; // En attendant la gestion des utilisateurs
            $filiere->save();

            // Récupérer les niveaux existants de la filière
            $existingNiveaux = $filiere->niveaux->keyBy('abreviation');
            $updatedNiveauxIds = [];

            // Traiter les niveaux
            if ($request->has('niveaux')) {
                foreach ($request->niveaux as $key => $niveauData) {
                    // Vérifier si le niveau est actif
                    if (isset($niveauData['active'])) {
                        // Si le niveau existe déjà, le mettre à jour
                        if (isset($niveauData['id']) && $existingNiveau = $existingNiveaux->get($niveauData['abreviation'])) {
                            $niveau = Niveau::find($niveauData['id']);
                            $niveau->accessible = isset($niveauData['accessible']) ? 1 : 0;
                            $niveau->statut = $niveauData['statut'] ?? 'active';
                            $niveau->updated_by = 'system';
                            $niveau->save();

                            // Mettre à jour les diplômes associés
                            if ($niveau->accessible && isset($niveauData['diplomes'])) {
                                $niveau->diplomes()->sync($niveauData['diplomes'], ['created_by' => 'system', 'updated_by' => 'system']);
                            } elseif (!$niveau->accessible) {
                                $niveau->diplomes()->detach();
                            }

                            $updatedNiveauxIds[] = $niveau->id;
                        } else {
                            // Créer un nouveau niveau
                            $niveau = new Niveau();
                            $niveau->libelle = $niveauData['libelle'];
                            $niveau->abreviation = $niveauData['abreviation'];
                            $niveau->filiere_id = $filiere->id;
                            $niveau->accessible = isset($niveauData['accessible']) ? 1 : 0;
                            $niveau->statut = $niveauData['statut'] ?? 'active';
                            $niveau->created_by = 'system';
                            $niveau->save();

                            // Si le niveau est accessible et que des diplômes ont été sélectionnés
                            if ($niveau->accessible && isset($niveauData['diplomes'])) {
                                $niveau->diplomes()->attach($niveauData['diplomes'], ['created_by' => 'system']);
                            }

                            $updatedNiveauxIds[] = $niveau->id;
                        }
                    }
                }
            }

            // Supprimer les niveaux qui ne sont plus actifs
            foreach ($existingNiveaux as $existingNiveau) {
                if (!in_array($existingNiveau->id, $updatedNiveauxIds)) {
                    // Option 1: Supprimer complètement le niveau
                    // $existingNiveau->delete();

                    // Option 2: Marquer comme inactif
                    $existingNiveau->statut = 'inactive';
                    $existingNiveau->updated_by = 'system';
                    $existingNiveau->save();
                }
            }

            DB::commit();
            return redirect()->route('filieres.index')->with('success', 'Filière mise à jour avec succès!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour de la filière: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Filiere $filiere)
    {
        try {
            $filiere->delete();
            return redirect()->route('filieres.index')->with('success', 'Filière supprimée avec succès!');
        } catch (\Exception $e) {
            return redirect()->route('filieres.index')->with('error', 'Une erreur est survenue lors de la suppression de la filière: ' . $e->getMessage());
        }
    }
}
