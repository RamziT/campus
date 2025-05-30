<?php

namespace App\Http\Controllers;

use App\Models\Diplome;
use Illuminate\Http\Request;
use App\Models\Filiere;

class ApiFiliereController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/filieres",
     *     summary="Récupérer la liste de toutes les filières",
     *     tags={"Filières"},
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
     *                 @OA\Property(property="responsable_id", type="string", example="12345"),
     *                 @OA\Property(property="contact", type="string", example="+226 25 30 70 65"),
     *                 @OA\Property(property="email", type="string", example="info@uo.bf"),
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
        $filieres = Filiere::where('statut', 'active')->get();
        return response()->json($filieres);
    }

    /**
     * @OA\Get(
     *     path="/api/filieres/{id}",
     *     summary="Récupérer une filière par son ID",
     *     tags={"Filières"},
     *     @OA\Parameter(
     *         name="id",
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
     *                 @OA\Property(property="departement_id", type="integer", example=1),
     *                 @OA\Property(property="libelle", type="string", example="Informatique"),
     *                 @OA\Property(property="abreviation", type="string", example="INFO"),
     *                 @OA\Property(property="responsable_id", type="string", example="12345"),
     *                 @OA\Property(property="contact", type="string", example="+226 25 30 70 65"),
     *                 @OA\Property(property="email", type="string", example="info@uo.bf"),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Filière non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function show($id)
    {
        $filiere = Filiere::where('id', $id)->where('statut', 'active')->get();
        return response()->json($filiere);
    }

    /**
     * @OA\Get(
     *     path="/api/filieres/{filiere}/niveaux",
     *     summary="Récupérer la liste des niveaux appartenant à une filière",
     *     tags={"Filières"},
     *     @OA\Parameter(
     *         name="filiere",
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
     *         description="Filière non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getNiveaux(Filiere $filiere)
    {
        $niveaux = $filiere->niveaux()->where('statut', 'active')->get();
        return response()->json($niveaux);
    }

    /**
     * @OA\Get(
     *     path="/api/filieres/{filiere}/niveaux-accessibles",
     *     summary="Récupérer la liste des niveaux accessibles appartenant à une filière",
     *     tags={"Filières"},
     *     @OA\Parameter(
     *         name="filiere",
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
     *         description="Filière non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getNiveauxAccessibles(Filiere $filiere)
    {
        $niveaux = $filiere->niveaux()
            ->where('statut', 'active')
            ->where('accessible', true)
            ->get();
        return response()->json($niveaux);
    }

    /**
     * @OA\Get(
     *     path="/api/filieres/{filiere}/diplomes",
     *     summary="Récupérer la liste des diplômes appartenant à une filière",
     *     tags={"Filières"},
     *     @OA\Parameter(
     *         name="filiere",
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
     *                 @OA\Property(property="libelle", type="string", example="Baccalauréat"),
     *                 @OA\Property(property="abreviation", type="string", example="BAC"),
     *                 @OA\Property(property="serie", type="string", example="C"),
     *                 @OA\Property(property="option", type="string", example="Mathématiques"),
     *                 @OA\Property(property="specialite", type="string", example="Sciences"),
     *                 @OA\Property(property="statut", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Filière non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function getDiplomes(Filiere $filiere)
    {
        $diplomes = Diplome::join('niveaux_diplomes', 'diplomes.id', '=', 'niveaux_diplomes.diplome_id')
        ->join('niveaux', 'niveaux_diplomes.niveau_id', '=', 'niveaux.id')
        ->join('filieres', 'niveaux.filiere_id', '=', 'filieres.id')
            ->where('niveaux.filiere_id', $filiere->id)
        ->where('diplomes.statut', 'active')
        ->select('diplomes.id', 'diplomes.libelle', 'diplomes.abreviation', 'diplomes.serie', 'diplomes.option', 'diplomes.specialite', 'diplomes.statut', 'filieres.id as filiere_id', 'filieres.libelle as filiere_libelle', )
        ->get();
        return response()->json($diplomes);
    }
}
