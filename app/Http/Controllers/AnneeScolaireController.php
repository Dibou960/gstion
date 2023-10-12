<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\AnneeScolaireResource;
use App\Models\AnneeScolaire;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AnneeScolaireController extends Controller
{
    public function index()
    {
        $anneesScolaires = AnneeScolaire::all();
        return response()->json(['anneescolaire' => AnneeScolaireResource::collection($anneesScolaires)], Response::HTTP_OK);
    }

    public function show($id)
    {
        $anneeScolaire = AnneeScolaire::findOrFail($id);
        return response()->json(['annee_scolaire' => new AnneeScolaireResource($anneeScolaire)], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle_annee' => 'required|regex:/^\d{4}-\d{4}$/|unique:anneescolaire,Libelle',
        ], [
            'libelle_annee.regex' => 'Le format de l\'année scolaire doit être YYYY-YYYY (par exemple, 2024-2025).',
            'libelle_annee.unique' => 'Cette année scolaire existe déjà.',
        ]);

        $libelleAnnee = $request->input('libelle_annee');

        list($anneeDebut, $anneeFin) = explode('-', $libelleAnnee);

        if (($anneeFin - $anneeDebut) !== 1) {
            return response()->json(['message' => 'L\'intervalle entre les années doit être égal à un an'], 400);
        }

        if ($anneeDebut >= $anneeFin) {
            return response()->json(['message' => 'L\'année de début doit être inférieure à l\'année de fin'], 400);
        }

        $anneeScolaire = AnneeScolaire::create([
            'Libelle' => $libelleAnnee,
        ]);

        return response()->json(['annee_scolaire' => $anneeScolaire], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        // Valider les données
        $request->validate([
            'libelle_annee' => 'required|regex:/^\d{4}-\d{4}$/|unique:anneescolaire,Libelle,' . $id,
        ], [
            'libelle_annee.regex' => 'Le format de l\'année scolaire doit être YYYY-YYYY (par exemple, 2024-2025).',
            'libelle_annee.unique' => 'Cette année scolaire existe déjà.'
        ]);
    
        // Récupérer le libellé de l'année scolaire depuis la requête
        $libelleAnnee = $request->input('libelle_annee');
    
        // Extraire les années de début et de fin
        list($anneeDebut, $anneeFin) = explode('-', $libelleAnnee);
    
        // Vérifier si l'intervalle est égal à un an
        if (($anneeFin - $anneeDebut) !== 1) {
            return response()->json(['message' => 'L\'intervalle entre les années doit être égal à un an'], 400);
        }
    
        if ($anneeDebut >= $anneeFin) {
            return response()->json(['message' => 'L\'année de début doit être inférieure à l\'année de fin'], 400);
        }
    
        // Mettre à jour l'année scolaire
        $anneeScolaire = AnneeScolaire::findOrFail($id);
        $anneeScolaire->update(['Libelle' => $libelleAnnee]);
    
        return response()->json(['annee_scolaire' => $anneeScolaire], Response::HTTP_OK);
    }
    

    public function destroy($id)
    {
        $anneeScolaire = AnneeScolaire::findOrFail($id);
        $anneeScolaire->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function getAnneeScolaireForClass($classeId)
    {
        // Récupérer l'AnnéeScolaireID pour la classe spécifiée par son ID
        $anneeScolaireId = DB::table('classe')
            ->where('id', $classeId)
            ->value('AnnéeScolaireID');

        if ($anneeScolaireId) {
            // Si l'AnnéeScolaireID est trouvé, récupérer le libellé de l'année scolaire correspondante
            $anneeScolaireLibelle = DB::table('anneescolaire')
                ->where('id', $anneeScolaireId)
                ->value('libelle');

            return ApiResponse::success(['annee_scolaire_id' => $anneeScolaireId, 'annee_scolaire_libelle' => $anneeScolaireLibelle], 'Année scolaire récupérée avec succès', 200);
        }

        return ApiResponse::error('Classe non trouvée ou AnnéeScolaireID non disponible pour cette classe.', 404);
    }
    public function getClasseForAnneeScolaire($anneeScolaireId)
    {
        try {
            // Récupérer la classe correspondant à l'année scolaire spécifiée
            $classe = Classe::where('AnnéeScolaireID', $anneeScolaireId)->first();

            if ($classe) {
                return ApiResponse::success($classe, 'Classe récupérée avec succès pour l\'année scolaire spécifiée', 200);
            }

            return ApiResponse::error('Aucune classe correspondante trouvée pour l\'année scolaire spécifiée', 404);
        } catch (\Exception $e) {
            dd($e->getMessage()); // Afficher le message d'erreur pour diagnostiquer
            return ApiResponse::error('Une erreur s\'est produite lors de la récupération de la classe.', 500);
        }
    }

}
