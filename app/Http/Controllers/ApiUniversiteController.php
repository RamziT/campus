<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Filiere;
use App\Models\Niveau;
use Illuminate\Http\Request;
use App\Models\Universite;

class ApiUniversiteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/universites",
     *     summary="Récupérer la liste de toutes les universités",
     *     tags={"Universités"},
     *     @OA\Response(
     *         response=200,
     *         description="Réponse de succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="libelle", type="string", example="Université de Ouagadougou"),
     *                 @OA\Property(property="abreviation", type="string", example="UO"),
     *                 @OA\Property(property="ville", type="string", example="Ouagadougou"),
     *                 @OA\Property(property="telephone", type="string", example="+226 25 30 70 64"),
     *                 @OA\Property(property="email", type="string", example="contact@uo.bf"),
     *                 @OA\Property(property="site_web", type="string", example="https://www.uo.bf"),
     *                 @OA\Property(property="adresse", type="string", example="03 BP 7021 Ouagadougou 03"),
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
        $universites = Universite::where('statut', 'active')->get();
        return response()->json($universites);
    }

    /**
     * @OA\Get(
     *     path="/api/universites/{id}",
     *     summary="Récupérer une université par son ID",
     *     tags={"Universités"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'université",
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
     *                 @OA\Property(property="libelle", type="string", example="Université de Ouagadougou"),
     *                 @OA\Property(property="abreviation", type="string", example="UO"),
     *                 @OA\Property(property="ville", type="string", example="Ouagadougou"),
     *                 @OA\Property(property="telephone", type="string", example="+226 25 30 70 64"),
     *                 @OA\Property(property="email", type="string", example="contact@uo.bf"),
     *                 @OA\Property(property="site_web", type="string", example="https://www.uo.bf"),
     *                 @OA\Property(property="adresse", type="string", example="03 BP 7021 Ouagadougou 03"),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Université non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function show($id)
    {
        $universite = Universite::where('id', $id)->where('statut', 'active')->get();
        return response()->json($universite);
    }

    /**
     * @OA\Get(
     *     path="/api/universites/{universite}/ufrs",
     *     summary="Récupérer la liste des UFRs appartenant à une université",
     *     tags={"Universités"},
     *     @OA\Parameter(
     *         name="universite",
     *         in="path",
     *         required=true,
     *         description="ID de l'université",
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
     *                 @OA\Property(property="libelle", type="string", example="UFR Sciences et Techniques"),
     *                 @OA\Property(property="abreviation", type="string", example="UFR/ST"),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Université non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getUfrs(Universite $universite)
    {
        $ufrs = $universite->ufrs()->where('statut', 'active')->get();
        return response()->json($ufrs);
    }

    /**
     * @OA\Get(
     *     path="/api/universites/{universite}/departements",
     *     summary="Récupérer la liste des départements appartenant à une université",
     *     tags={"Universités"},
     *     @OA\Parameter(
     *         name="universite",
     *         in="path",
     *         required=true,
     *         description="ID de l'université",
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
     *                 @OA\Property(property="libelle", type="string", example="Département de Mathématiques"),
     *                 @OA\Property(property="abreviation", type="string", example="MATH"),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Université non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getDepartements(Universite $universite)
    {
        $departements = Departement::join('ufr', 'departements.ufr_id', '=', 'ufr.id')
        ->join('universites', 'ufr.universite_id', '=', 'universites.id')
            ->where('ufr.universite_id', $universite->id)
            ->where('departements.statut', 'active')
            ->select('departements.*', 'ufr.id as ufr_id', 'ufr.libelle as ufr_libelle', 'universites.id as universite_id', 'universites.libelle as universite_libelle', 'ufr.libelle as ufr_libelle')
            ->get();
        return response()->json($departements);
    }

    /**
     * @OA\Get(
     *     path="/api/universites/{universite}/filieres",
     *     summary="Récupérer la liste des filières appartenant à une université",
     *     tags={"Universités"},
     *     @OA\Parameter(
     *         name="universite",
     *         in="path",
     *         required=true,
     *         description="ID de l'université",
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
     *                 @OA\Property(property="libelle", type="string", example="Informatique"),
     *                 @OA\Property(property="abreviation", type="string", example="INFO"),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Université non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getFilieres(Universite $universite)
    {
        $filieres = Filiere::join('departements', 'filieres.departement_id', '=', 'departements.id')
        ->join('ufr', 'departements.ufr_id', '=', 'ufr.id')
        ->join('universites', 'ufr.universite_id', '=', 'universites.id')
            ->where('ufr.universite_id', $universite->id)
            ->where('filieres.statut', 'active')
            ->select('filieres.*', 'departements.id as departement_id', 'departements.libelle as departement_libelle', 'ufr.id as ufr_id', 'ufr.libelle as ufr_libelle', 'universites.id as universite_id', 'universites.libelle as universite_libelle', 'ufr.libelle as ufr_libelle')
            ->get();
        return response()->json($filieres);
    }

    /**
     * @OA\Get(
     *     path="/api/universites/{universite}/niveaux",
     *     summary="Récupérer la liste des niveaux appartenant à une université",
     *     tags={"Universités"},
     *     @OA\Parameter(
     *         name="universite",
     *         in="path",
     *         required=true,
     *         description="ID de l'université",
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
     *                 @OA\Property(property="accessible", type="boolean", example=true),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Université non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getNiveaux(Universite $universite)
    {
        $niveaux = Niveau::join('filieres', 'niveaux.filiere_id', '=', 'filieres.id')
        ->join('departements', 'filieres.departement_id', '=', 'departements.id')
        ->join('ufr', 'departements.ufr_id', '=', 'ufr.id')
        ->join('universites', 'ufr.universite_id', '=', 'universites.id')
            ->where('ufr.universite_id', $universite->id)
            ->where('niveaux.statut', 'active')
            ->select('niveaux.*', 'filieres.id as filiere_id', 'filieres.libelle as filiere_libelle', 'departements.id as departement_id', 'departements.libelle as departement_libelle', 'ufr.id as ufr_id', 'ufr.libelle as ufr_libelle', 'universites.id as universite_id', 'universites.libelle as universite_libelle', 'ufr.libelle as ufr_libelle')
            ->get();
        return response()->json($niveaux);
    }

    /**
     * @OA\Get(
     *     path="/api/universites/{universite}/niveaux-accessibles",
     *     summary="Récupérer la liste des niveaux accessibles appartenant à une université",
     *     tags={"Universités"},
     *     @OA\Parameter(
     *         name="universite",
     *         in="path",
     *         required=true,
     *         description="ID de l'université",
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
     *                 @OA\Property(property="accessible", type="boolean", example=true),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Université non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getNiveauxAccessibles(Universite $universite)
    {
        $niveaux = Niveau::join('filieres', 'niveaux.filiere_id', '=', 'filieres.id')
        ->join('departements', 'filieres.departement_id', '=', 'departements.id')
        ->join('ufr', 'departements.ufr_id', '=', 'ufr.id')
        ->join('universites', 'ufr.universite_id', '=', 'universites.id')
            ->where('ufr.universite_id', $universite->id)
            ->where('niveaux.statut', 'active')
            ->where('niveaux.accessible', true)
            ->select('niveaux.*', 'filieres.id as filiere_id', 'filieres.libelle as filiere_libelle', 'departements.id as departement_id', 'departements.libelle as departement_libelle', 'ufr.id as ufr_id', 'ufr.libelle as ufr_libelle', 'universites.id as universite_id', 'universites.libelle as universite_libelle', 'ufr.libelle as ufr_libelle')
            ->get();
        return response()->json($niveaux);
    }
}
