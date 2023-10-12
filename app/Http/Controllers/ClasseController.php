<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\AnneeScolaire;
use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{

    public function index()
    {
        $classes = Classe::all();
        return ApiResponse::success(['classes' => $classes], 200);
    }

    public function show($id)
    {
        $classe = Classe::find($id);

        if (!$classe) {
            return ApiResponse::error(['message' => 'Classe non trouvée'], 404);
        }

        return ApiResponse::success(['classe' => $classe], 200);
    }

    public function update(Request $request, $id)
    {
        // Valider les données
        $request->validate([
            'Libelle' => 'required|string',
            'Filiere' => 'required|string',
            'Niveau' => 'required|string',
            'AnnéeScolaireLibelle' => 'required|string',
        ]);

        $classe = Classe::find($id);

        if (!$classe) {
            return ApiResponse::error(['message' => 'Classe non trouvée'], 404);
        }

        // Mettre à jour les détails de la classe
        $classe->update([
            'Libelle' => $request->input('Libelle'),
            'Filiere' => $request->input('Filiere'),
            'Niveau' => $request->input('Niveau'),
        ]);

        return ApiResponse::success(['message' => 'Classe mise à jour avec succès', 'classe' => $classe], 200);
    }

    public function destroy($id)
    {
        $classe = Classe::find($id);

        if (!$classe) {
            return ApiResponse::error(['message' => 'Classe non trouvée'], 404);
        }

        $classe->delete();

        return ApiResponse::success(['message' => 'Classe supprimée avec succès'], 200);
    }

    public function store(Request $request)
    {

        // Trouver l'ID de l'année scolaire par le libellé
        $annéeScolaire = AnneeScolaire::where('Libelle', $request->input('AnnéeScolaireLibelle'))->first();

        if (!$annéeScolaire) {
            return ApiResponse::error(['message' => 'Année scolaire non trouvée'], 404);
        }

        // Créer une nouvelle classe avec l'ID de l'année scolaire associée
        $classe = Classe::create([
            'Libelle' => $request->input('Libelle'),
            'Filiere' => $request->input('Filiere'),
            'Niveau' => $request->input('Niveau'),
            'AnnéeScolaireID' => $annéeScolaire->id,
        ]);

        return ApiResponse::success(['message' => 'Classe créée avec succès', 'classe' => $classe], 201);
    }
}
