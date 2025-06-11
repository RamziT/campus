<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Niveau;
use App\Models\Diplome;

class ApiNiveauController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/niveaux",
     *     summary="Récupérer la liste de tous les niveaux",
     *     tags={"Niveaux"},
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
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function index()
    {
        $niveaux = Niveau::where('statut', 'active')->get();
        return response()->json($niveaux);
    }

    /**
     * @OA\Get(
     *     path="/api/niveaux/{id}",
     *     summary="Récupérer un niveau par son ID",
     *     tags={"Niveaux"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du niveau",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Réponse de succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="libelle", type="string", example="Licence 1"),
     *             @OA\Property(property="abreviation", type="string", example="L1"),
     *             @OA\Property(property="filiere_id", type="integer", example=1),
     *             @OA\Property(property="accessible", type="boolean", example=true),
     *             @OA\Property(property="statut", type="string", example="active")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Niveau non trouvé"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function show($id)
    {
        $niveau = Niveau::where('id', $id)->where('statut', 'active')->first();

        if (!$niveau) {
            return response()->json(['message' => 'Niveau non trouvé'], 404);
        }

        return response()->json($niveau);
    }

    /**
     * @OA\Get(
     *     path="/api/niveaux/accessibles",
     *     summary="Récupérer la liste des niveaux accessibles",
     *     tags={"Niveaux"},
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
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getAccessibles()
    {
        $niveaux = Niveau::where('statut', 'active')
            ->where('accessible', true)
            ->get();
        return response()->json($niveaux);
    }

    /**
     * @OA\Get(
     *     path="/api/niveaux/{niveau}/diplomes",
     *     summary="Récupérer la liste des diplômes requis pour un niveau",
     *     tags={"Niveaux"},
     *     @OA\Parameter(
     *         name="niveau",
     *         in="path",
     *         required=true,
     *         description="ID du niveau",
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
     *         response=404,
     *         description="Niveau non trouvé"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getDiplomes(Niveau $niveau)
    {
        $diplomes = $niveau->diplomes()->where('statut', 'active')->get();
        return response()->json($diplomes);
    }

    /**
     * @OA\Get(
     *     path="/api/niveaux/filiere/{filiere_id}",
     *     summary="Récupérer les niveaux d'une filière",
     *     tags={"Niveaux"},
     *     @OA\Parameter(
     *         name="filiere_id",
     *         in="path",
     *         required=true,
     *         description="ID de la filière",
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
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getByFiliere($filiere_id)
    {
        $niveaux = Niveau::where('filiere_id', $filiere_id)
            ->where('statut', 'active')
            ->orderBy('libelle')
            ->get();
        return response()->json($niveaux);
    }

    /**
     * @OA\Get(
     *     path="/api/niveaux-accessibles",
     *     summary="Récupérer les niveaux accessibles",
     *     tags={"Niveaux"},
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
     *         description="Niveaux non trouvés"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getAllNiveauxAccessibles()
    {
        $filieres_accessibles = Diplome::join('niveaux_diplomes', 'diplomes.id', '=', 'niveaux_diplomes.diplome_id')
            ->join('niveaux', 'niveaux_diplomes.niveau_id', '=', 'niveaux.id')
            ->join('filieres', 'niveaux.filiere_id', '=', 'filieres.id')
            ->join('departements', 'filieres.departement_id', '=', 'departements.id')
            ->join('ufr', 'departements.ufr_id', '=', 'ufr.id')
            ->join('universites', 'ufr.universite_id', '=', 'universites.id')
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
}
