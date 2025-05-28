<?php

namespace App\Http\Controllers;

use App\Models\Diplome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiDiplomeController extends Controller
{
    public function getFilieresAccessibles($diplome)
    {
        // // Validate the request
        // $request->validate([
        //     'id' => 'required|integer|exists:universites,id',
        // ]);

        $filieres_accessibles = Diplome::join('niveaux_diplomes', 'diplomes.id', '=', 'niveaux_diplomes.diplome_id')
            ->join('niveaux', 'niveaux_diplomes.niveau_id', '=', 'niveaux.id')
            ->join('filieres', 'niveaux.filiere_id', '=', 'filieres.id')
            ->join('departements', 'filieres.departement_id', '=', 'departements.id')
            ->join('ufr', 'departements.ufr_id', '=', 'ufr.id')
            ->join('universites', 'ufr.universite_id', '=', 'universites.id')
            ->where('diplomes.id', $diplome)
            ->select('diplomes.id as diplome_id', 'diplomes.libelle as diplome_libelle', 'diplomes.serie as diplome_serie', 'diplomes.option as diplome_option', 'diplomes.specialite as diplome_specialite', 'filieres.id as filiere_id', 'filieres.libelle as filiere_libelle', 'departements.id as departement_id', 'departements.libelle as departement_libelle', 'ufr.id as ufr_id', 'ufr.libelle as ufr_libelle', 'universites.id as universite_id', 'universites.libelle as universite_libelle')
            ->get();

        // Return the filieres as a JSON response
        return response()->json($filieres_accessibles);
    }

    public function getBaccalaureats(){
        $baccalaureats = Diplome::where('libelle', 'like', '%Baccalauréat%')
        ->orderBy('serie', 'asc')
        ->select('id', DB::raw("CONCAT(abreviation, ' ', serie) as intitule"), 'specialite')
        ->get();

        // Return the baccaulerats as a JSON response
        return response()->json($baccalaureats);
    }
}
