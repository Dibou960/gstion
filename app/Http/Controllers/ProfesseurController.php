<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Professeur;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Enseignementmodule;

class ProfesseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $professeurs = Professeur::with(['modules' => function ($query) {
            $query->select('id', 'Libelle');
        }])
            ->select('id', 'prenom')
            ->get();

        return ApiResponse::success($professeurs, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données de la requête
        $request->validate([
            'prenom' => 'required|string',
            'module' => 'required|string',
        ]);

        // Récupérer le module en fonction du nom
        $module = Module::where('Libelle', $request->input('module'))->first();

        // Si le module n'existe pas, on le crée
        if (!$module) {
            $module = Module::create([
                'Libelle' => $request->input('module'),
            ]);
        }

        // Créer un nouveau professeur avec le moduleID associé
        $professeur = Professeur::create([
            'prenom' => $request->input('prenom'),
            'Libelle' => $module->id,
        ]);

        // Associer le module au professeur dans la table d'association
        $enseignementModule = new Enseignementmodule();
        $enseignementModule->ProfesseurID = $professeur->id;
        $enseignementModule->ModuleID = $module->id;
        $enseignementModule->save();

        return ApiResponse::success( 'Professeur ajouté avec le module associé', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Professeur $professeur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Professeur $professeur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Valider les données de la requête
        $request->validate([
            'prenom' => 'required|string',
            'module' => 'required|string',
        ]);

        // Récupérer le professeur à mettre à jour
        $professeur = Professeur::findOrFail($id);

        // Récupérer le module en fonction du nom
        $module = Module::where('Libelle', $request->input('module'))->first();

        // Si le module n'existe pas, on le crée
        if (!$module) {
            $module = Module::create([
                'Libelle' => $request->input('module'),
            ]);
        }

        // Mettre à jour le professeur avec le nouveau prénom
        $professeur->prenom = $request->input('prenom');
        $professeur->save();

        // Associer le module au professeur dans la table d'association
        $enseignementModule = Enseignementmodule::where('ProfesseurID', $professeur->id)->first();
        if ($enseignementModule) {
            // Mettre à jour le module associé au professeur
            $enseignementModule->ModuleID = $module->id;
            $enseignementModule->save();
        } else {
            // Si aucune association n'existe, en créer une nouvelle
            $enseignementModule = new Enseignementmodule();
            $enseignementModule->ProfesseurID = $professeur->id;
            $enseignementModule->ModuleID = $module->id;
            $enseignementModule->save();
        }

        return ApiResponse::succes('Professeur mis à jour avec le module associé', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Professeur $professeur)
    {
        //
    }
}
