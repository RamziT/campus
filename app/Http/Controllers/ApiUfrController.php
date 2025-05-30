<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Filiere;
use App\Models\Niveau;
use Illuminate\Http\Request;
use App\Models\UFR;

class ApiUfrController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ufrs",
     *     summary="Récupérer la liste de toutes les UFR",
     *     tags={"UFR"},
     *     @OA\Response(
     *         response=200,
     *         description="Réponse de succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="universite_id", type="integer", example=1),
     *                 @OA\Property(property="libelle", type="string", example="UFR Sciences et Techniques"),
     *                 @OA\Property(property="abreviation", type="string", example="UFR/ST"),
     *                 @OA\Property(property="responsable_id", type="string", example="12345"),
     *                 @OA\Property(property="contact", type="string", example="+226 25 30 70 65"),
     *                 @OA\Property(property="email", type="string", example="ufrst@uo.bf"),
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
        $ufrs = UFR::where('statut', 'active')->get();
        return response()->json($ufrs);
    }

    /**
     * @OA\Get(
     *     path="/api/ufrs/{id}",
     *     summary="Récupérer une UFR par son ID",
     *     tags={"UFR"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'UFR",
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
     *                 @OA\Property(property="universite_id", type="integer", example=1),
     *                 @OA\Property(property="libelle", type="string", example="UFR Sciences et Techniques"),
     *                 @OA\Property(property="abreviation", type="string", example="UFR/ST"),
     *                 @OA\Property(property="responsable_id", type="string", example="12345"),
     *                 @OA\Property(property="contact", type="string", example="+226 25 30 70 65"),
     *                 @OA\Property(property="email", type="string", example="ufrst@uo.bf"),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="UFR non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function show($id)
    {
        $ufr = UFR::where('id', $id)->where('statut', 'active')->get();
        return response()->json($ufr);
    }

    /**
     * @OA\Get(
     *     path="/api/ufrs/{ufr}/departements",
     *     summary="Récupérer la liste des départements appartenant à une UFR",
     *     tags={"UFR"},
     *     @OA\Parameter(
     *         name="ufr",
     *         in="path",
     *         required=true,
     *         description="ID de l'UFR",
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
     *                 @OA\Property(property="responsable_id", type="string", example="12346"),
     *                 @OA\Property(property="contact", type="string", example="+226 25 30 70 66"),
     *                 @OA\Property(property="email", type="string", example="math@uo.bf"),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="UFR non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getDepartements(UFR $ufr)
    {
        $departements = Departement::join('ufr', 'departements.ufr_id', '=', 'ufr.id')
        ->join('universites', 'ufr.universite_id', '=', 'universites.id')
            ->where('departements.ufr_id', $ufr->id)
            ->where('departements.statut', 'active')
            ->select('departements.*', 'ufr.id as ufr_id', 'ufr.libelle as ufr_libelle', 'universites.id as universite_id', 'universites.libelle as universite_libelle', 'ufr.libelle as ufr_libelle')
            ->get();
        return response()->json($departements);
    }

    /**
     * @OA\Get(
     *     path="/api/ufrs/{ufr}/filieres",
     *     summary="Récupérer la liste des filières appartenant à une UFR",
     *     tags={"UFR"},
     *     @OA\Parameter(
     *         name="ufr",
     *         in="path",
     *         required=true,
     *         description="ID de l'UFR",
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
     *                 @OA\Property(property="responsable_id", type="string", example="12347"),
     *                 @OA\Property(property="contact", type="string", example="+226 25 30 70 67"),
     *                 @OA\Property(property="email", type="string", example="info@uo.bf"),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="UFR non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getFilieres(UFR $ufr)
    {
        $filieres = Filiere::join('departements', 'filieres.departement_id', '=', 'departements.id')
        ->join('ufr', 'departements.ufr_id', '=', 'ufr.id')
        ->join('universites', 'ufr.universite_id', '=', 'universites.id')
            ->where('ufr.id', $ufr->id)
            ->where('filieres.statut', 'active')
            ->select('filieres.*', 'departements.id as departement_id', 'departements.libelle as departement_libelle', 'ufr.id as ufr_id', 'ufr.libelle as ufr_libelle', 'universites.id as universite_id', 'universites.libelle as universite_libelle', 'ufr.libelle as ufr_libelle')
            ->get();
        return response()->json($filieres);
    }

    /**
     * @OA\Get(
     *     path="/api/ufrs/{ufr}/niveaux",
     *     summary="Récupérer la liste des niveaux appartenant à une UFR",
     *     tags={"UFR"},
     *     @OA\Parameter(
     *         name="ufr",
     *         in="path",
     *         required=true,
     *         description="ID de l'UFR",
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
     *         description="UFR non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getNiveaux(UFR $ufr)
    {
        $niveaux = Niveau::join('filieres', 'niveaux.filiere_id', '=', 'filieres.id')
        ->join('departements', 'filieres.departement_id', '=', 'departements.id')
        ->join('ufr', 'departements.ufr_id', '=', 'ufr.id')
        ->join('universites', 'ufr.universite_id', '=', 'universites.id')
            ->where('ufr.id', $ufr->id)
            ->where('niveaux.statut', 'active')
            ->select('niveaux.*', 'filieres.id as filiere_id', 'filieres.libelle as filiere_libelle', 'departements.id as departement_id', 'departements.libelle as departement_libelle', 'ufr.id as ufr_id', 'ufr.libelle as ufr_libelle', 'universites.id as universite_id', 'universites.libelle as universite_libelle', 'ufr.libelle as ufr_libelle')
            ->get();
        return response()->json($niveaux);
    }

    /**
     * @OA\Get(
     *     path="/api/ufrs/{ufr}/niveaux-accessibles",
     *     summary="Récupérer la liste des niveaux accessibles appartenant à une UFR",
     *     tags={"UFR"},
     *     @OA\Parameter(
     *         name="ufr",
     *         in="path",
     *         required=true,
     *         description="ID de l'UFR",
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
     *         description="UFR non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getNiveauxAccessibles(UFR $ufr)
    {
        $niveaux = Niveau::join('filieres', 'niveaux.filiere_id', '=', 'filieres.id')
        ->join('departements', 'filieres.departement_id', '=', 'departements.id')
        ->join('ufr', 'departements.ufr_id', '=', 'ufr.id')
        ->join('universites', 'ufr.universite_id', '=', 'universites.id')
            ->where('ufr.id', $ufr->id)
            ->where('niveaux.statut', 'active')
            ->where('niveaux.accessible', true)
            ->select('niveaux.*', 'filieres.id as filiere_id', 'filieres.libelle as filiere_libelle', 'departements.id as departement_id', 'departements.libelle as departement_libelle', 'ufr.id as ufr_id', 'ufr.libelle as ufr_libelle', 'universites.id as universite_id', 'universites.libelle as universite_libelle', 'ufr.libelle as ufr_libelle')
            ->get();
        return response()->json($niveaux);
    }
}
