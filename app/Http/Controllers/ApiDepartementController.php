<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\Niveau;

class ApiDepartementController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/departements",
     *     summary="Récupérer la liste de tous les départements",
     *     tags={"Départements"},
     *     @OA\Response(
     *         response=200,
     *         description="Réponse de succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="ufr_id", type="integer", example=1),
     *                 @OA\Property(property="libelle", type="string", example="Département de Mathématiques"),
     *                 @OA\Property(property="abreviation", type="string", example="MATH"),
     *                 @OA\Property(property="responsable_id", type="string", example="12345"),
     *                 @OA\Property(property="contact", type="string", example="+226 25 30 70 65"),
     *                 @OA\Property(property="email", type="string", example="math@uo.bf"),
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
        $departements = Departement::where('statut', 'active')->get();
        return response()->json($departements);
    }

    /**
     * @OA\Get(
     *     path="/api/departements/{id}",
     *     summary="Récupérer un département par son ID",
     *     tags={"Départements"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du département",
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
     *                 @OA\Property(property="ufr_id", type="integer", example=1),
     *                 @OA\Property(property="libelle", type="string", example="Département de Mathématiques"),
     *                 @OA\Property(property="abreviation", type="string", example="MATH"),
     *                 @OA\Property(property="responsable_id", type="string", example="12345"),
     *                 @OA\Property(property="contact", type="string", example="+226 25 30 70 65"),
     *                 @OA\Property(property="email", type="string", example="math@uo.bf"),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Département non trouvé"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function show($id)
    {
        $departement = Departement::where('id', $id)->where('statut', 'active')->get();
        return response()->json($departement);
    }

    /**
     * @OA\Get(
     *     path="/api/departements/{departement}/filieres",
     *     summary="Récupérer la liste des filières appartenant à un département",
     *     tags={"Départements"},
     *     @OA\Parameter(
     *         name="departement",
     *         in="path",
     *         required=true,
     *         description="ID du département",
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
     *                 @OA\Property(property="departement_id", type="integer", example=1),
     *                 @OA\Property(property="libelle", type="string", example="Informatique"),
     *                 @OA\Property(property="abreviation", type="string", example="INFO"),
     *                 @OA\Property(property="responsable_id", type="string", example="12346"),
     *                 @OA\Property(property="contact", type="string", example="+226 25 30 70 66"),
     *                 @OA\Property(property="email", type="string", example="info@uo.bf"),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Département non trouvé"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getFilieres(Departement $departement)
    {
        $filieres = $departement->filieres()->where('statut', 'active')->get();
        return response()->json($filieres);
    }

    /**
     * @OA\Get(
     *     path="/api/departements/{departement}/niveaux",
     *     summary="Récupérer la liste des niveaux appartenant à un département",
     *     tags={"Départements"},
     *     @OA\Parameter(
     *         name="departement",
     *         in="path",
     *         required=true,
     *         description="ID du département",
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
     *                 @OA\Property(property="filiere_id", type="integer", example=1),
     *                 @OA\Property(property="libelle", type="string", example="Licence 1"),
     *                 @OA\Property(property="abreviation", type="string", example="L1"),
     *                 @OA\Property(property="accessible", type="boolean", example=true),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Département non trouvé"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getNiveaux(Departement $departement)
    {
        $niveaux = Niveau::join('filieres', 'niveaux.filiere_id', '=', 'filieres.id')
        ->join('departements', 'filieres.departement_id', '=', 'departements.id')
        ->join('ufr', 'departements.ufr_id', '=', 'ufr.id')
        ->join('universites', 'ufr.universite_id', '=', 'universites.id')
            ->where('departements.id', $departement->id)
            ->where('niveaux.statut', 'active')
            ->select('niveaux.*', 'filieres.id as filiere_id', 'filieres.libelle as filiere_libelle', 'departements.id as departement_id', 'departements.libelle as departement_libelle', 'ufr.id as ufr_id', 'ufr.libelle as ufr_libelle', 'universites.id as universite_id', 'universites.libelle as universite_libelle', 'ufr.libelle as ufr_libelle')
            ->get();
        return response()->json($niveaux);
    }

    /**
     * @OA\Get(
     *     path="/api/departements/{departement}/niveaux-accessibles",
     *     summary="Récupérer la liste des niveaux accessibles appartenant à un département",
     *     tags={"Départements"},
     *     @OA\Parameter(
     *         name="departement",
     *         in="path",
     *         required=true,
     *         description="ID du département",
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
     *                 @OA\Property(property="filiere_id", type="integer", example=1),
     *                 @OA\Property(property="libelle", type="string", example="Licence 1"),
     *                 @OA\Property(property="abreviation", type="string", example="L1"),
     *                 @OA\Property(property="accessible", type="boolean", example=true),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Département non trouvé"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getNiveauxAccessibles(Departement $departement)
    {
        $niveaux = Niveau::join('filieres', 'niveaux.filiere_id', '=', 'filieres.id')
        ->join('departements', 'filieres.departement_id', '=', 'departements.id')
        ->join('ufr', 'departements.ufr_id', '=', 'ufr.id')
        ->join('universites', 'ufr.universite_id', '=', 'universites.id')
            ->where('departements.id', $departement->id)
            ->where('niveaux.statut', 'active')
            ->where('niveaux.accessible', true)
            ->select('niveaux.*', 'filieres.id as filiere_id', 'filieres.libelle as filiere_libelle', 'departements.id as departement_id', 'departements.libelle as departement_libelle', 'ufr.id as ufr_id', 'ufr.libelle as ufr_libelle', 'universites.id as universite_id', 'universites.libelle as universite_libelle', 'ufr.libelle as ufr_libelle')
            ->get();
        return response()->json($niveaux);
    }
}
