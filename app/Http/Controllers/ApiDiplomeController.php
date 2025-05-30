<?php

namespace App\Http\Controllers;

use App\Models\Diplome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

class ApiDiplomeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/diplomes",
     *     summary="Récupérer la liste de tous les diplômes",
     *     tags={"Diplômes"},
     *     @OA\Response(
     *         response=200,
     *         description="Réponse de succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="libelle", type="string", example="Baccalauréat"),
     *                 @OA\Property(property="abreviation", type="string", example="BAC"),
     *                 @OA\Property(property="serie", type="string", example="C"),
     *                 @OA\Property(property="specialite", type="string", example="Mathématiques"),
     *                 @OA\Property(property="option", type="string", example="Sciences"),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function index()
    {
        $diplomes = Diplome::where('statut', 'active')->get();
        return response()->json($diplomes);
    }

    /**
     * @OA\Get(
     *     path="/api/diplomes/{id}",
     *     summary="Récupérer un diplôme par son ID",
     *     tags={"Diplômes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du diplôme",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Réponse de succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="libelle", type="string", example="Baccalauréat"),
     *             @OA\Property(property="abreviation", type="string", example="BAC"),
     *             @OA\Property(property="serie", type="string", example="C"),
     *             @OA\Property(property="specialite", type="string", example="Mathématiques"),
     *             @OA\Property(property="option", type="string", example="Sciences"),
     *             @OA\Property(property="statut", type="string", example="active")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Diplôme non trouvé"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function show($id)
    {
        $diplome = Diplome::where('id', $id)->where('statut', 'active')->first();

        if (!$diplome) {
            return response()->json(['message' => 'Diplôme non trouvé'], 404);
        }

        return response()->json($diplome);
    }

    /**
     * @OA\Get(
     *     path="/api/diplomes/{diplome}/filieres",
     *     summary="Récupérer les filières accessibles pour un diplôme",
     *     tags={"Diplômes"},
     *     @OA\Parameter(
     *         name="diplome",
     *         in="path",
     *         required=true,
     *         description="ID du diplôme",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Réponse de succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="diplome_id", type="integer", example=1),
     *                 @OA\Property(property="diplome_libelle", type="string", example="Baccalauréat"),
     *                 @OA\Property(property="diplome_serie", type="string", example="C"),
     *                 @OA\Property(property="diplome_option", type="string", example="Sciences"),
     *                 @OA\Property(property="diplome_specialite", type="string", example="Mathématiques"),
     *                 @OA\Property(property="filiere_id", type="integer", example=1),
     *                 @OA\Property(property="filiere_libelle", type="string", example="Informatique"),
     *                 @OA\Property(property="departement_id", type="integer", example=1),
     *                 @OA\Property(property="departement_libelle", type="string", example="Département de Mathématiques"),
     *                 @OA\Property(property="ufr_id", type="integer", example=1),
     *                 @OA\Property(property="ufr_libelle", type="string", example="UFR Sciences et Techniques"),
     *                 @OA\Property(property="universite_id", type="integer", example=1),
     *                 @OA\Property(property="universite_libelle", type="string", example="Université de Ouagadougou")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Diplôme non trouvé"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getFilieresAccessibles($diplome)
    {
        $filieres_accessibles = Diplome::join('niveaux_diplomes', 'diplomes.id', '=', 'niveaux_diplomes.diplome_id')
            ->join('niveaux', 'niveaux_diplomes.niveau_id', '=', 'niveaux.id')
            ->join('filieres', 'niveaux.filiere_id', '=', 'filieres.id')
            ->join('departements', 'filieres.departement_id', '=', 'departements.id')
            ->join('ufr', 'departements.ufr_id', '=', 'ufr.id')
            ->join('universites', 'ufr.universite_id', '=', 'universites.id')
            ->where('diplomes.id', $diplome)
            ->where('diplomes.statut', 'active')
            ->where('filieres.statut', 'active')
            ->where('departements.statut', 'active')
            ->where('ufr.statut', 'active')
            ->where('universites.statut', 'active')
            ->select(
                'diplomes.id as diplome_id',
                'diplomes.libelle as diplome_libelle',
                'diplomes.serie as diplome_serie',
                'diplomes.option as diplome_option',
                'diplomes.specialite as diplome_specialite',
                'filieres.id as filiere_id',
                'filieres.libelle as filiere_libelle',
                'departements.id as departement_id',
                'departements.libelle as departement_libelle',
                'ufr.id as ufr_id',
                'ufr.libelle as ufr_libelle',
                'universites.id as universite_id',
                'universites.libelle as universite_libelle'
            )
            ->get();

        return response()->json($filieres_accessibles);
    }

    /**
     * @OA\Get(
     *     path="/api/diplomes/{diplome}/niveaux",
     *     summary="Récupérer les niveaux accessibles avec un diplôme",
     *     tags={"Diplômes"},
     *     @OA\Parameter(
     *         name="diplome",
     *         in="path",
     *         required=true,
     *         description="ID du diplôme",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Réponse de succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="libelle", type="string", example="Licence 1"),
     *                 @OA\Property(property="abreviation", type="string", example="L1"),
     *                 @OA\Property(property="filiere_id", type="integer", example=1),
     *                 @OA\Property(property="accessible", type="boolean", example=true),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Diplôme non trouvé"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getNiveaux(Diplome $diplome)
    {
        $niveaux = $diplome->niveaux()->where('statut', 'active')->get();
        return response()->json($niveaux);
    }

    /**
     * @OA\Get(
     *     path="/api/baccalaureats",
     *     summary="Récupérer les baccalauréats",
     *     tags={"Diplômes"},
     *     @OA\Response(
     *         response=200,
     *         description="Réponse de succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="intitule", type="string", example="BAC C"),
     *                 @OA\Property(property="specialite", type="string", example="Mathématiques")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getBaccalaureats()
    {
        $baccalaureats = Diplome::where('libelle', 'like', '%Baccalauréat%')
            ->where('statut', 'active')
            ->orderBy('serie', 'asc')
            ->select('id', DB::raw("CONCAT(abreviation, ' ', serie) as intitule"), 'specialite')
            ->get();

        return response()->json($baccalaureats);
    }

    /**
     * @OA\Get(
     *     path="/api/diplomes/types/{type}",
     *     summary="Récupérer les diplômes par type",
     *     tags={"Diplômes"},
     *     @OA\Parameter(
     *         name="type",
     *         in="path",
     *         required=true,
     *         description="Type de diplôme (Baccalauréat, Licence, Master, etc.)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Réponse de succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="libelle", type="string", example="Baccalauréat"),
     *                 @OA\Property(property="abreviation", type="string", example="BAC"),
     *                 @OA\Property(property="serie", type="string", example="C"),
     *                 @OA\Property(property="specialite", type="string", example="Mathématiques"),
     *                 @OA\Property(property="option", type="string", example="Sciences"),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getByType($type)
    {
        $diplomes = Diplome::where('libelle', $type)
            ->where('statut', 'active')
            ->orderBy('serie')
            ->orderBy('specialite')
            ->get();

        return response()->json($diplomes);
    }
}
