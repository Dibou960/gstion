<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use App\Models\Classe;
use App\Models\Course;
use App\Models\Module;
use App\Models\Semestre;
use App\Models\Professeur;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['sessions.salle', 'semestre', 'professeur', 'module', 'classe'])->get();

        $formattedCourses = $courses->map(function ($course) {
            $formattedCourse = [
                'id' => $course->id,
                'NombreHeuresGlobal' => $course->NombreHeuresGlobal,
                'QuotaHoraire' => $course->QuotaHoraire,
                'SemestreName' => $course->semestre ? $course->semestre->Libelle : null,
                'ProfesseurName' => $course->professeur ? $course->professeur->Prenom : null,
                'ModuleName' => $course->module ? $course->module->Libelle : null,
                'ClasseName' => $course->classe ? $course->classe->Libelle : null,
                'SalleName' => $course->sessions->isNotEmpty() ? ($course->sessions[0]->salle ? $course->sessions[0]->salle->Nom : null) : null,
                'sessions' => $course->sessions->map(function ($session) {
                    return [
                        'id' => $session->id,
                        'Date' => $session->Date,
                        'HeureDebut' => $session->HeureDebut,
                        'HeureFin' => $session->HeureFin,
                        'NombreHeures' => $session->NombreHeures,
                        'salle' => $session->salle,
                    ];
                }),
            ];

            return $formattedCourse;
        });

        return response()->json(['courses' => $formattedCourses->toArray()], 200);

    }
    public function store(Request $request)
    {
        $request->validate([
            'NombreHeuresGlobal' => 'required|integer',
            'SemestreID' => 'required|string',
            'ProfesseurID' => 'required|string',
            // 'ProfesseurNom' => 'required|string',
            'ModuleId' => 'required|string',
            'ClasseId' => 'required|string',
            'QuotaHoraire' => 'required|integer',
        ]);

        try {

            // $semestreID = Semestre::where('Libelle', $request->input('SemestreLibelle'))->value('id');
            // $professeurID = Professeur::where('Prenom', $request->input('ProfesseurPrenom'))
            //     ->where('Nom', $request->input('ProfesseurNom'))
            //     ->value('id');
            // $moduleID = Module::where('Libelle', $request->input('ModuleLibelle'))->value('id');
            // $classeID = Classe::where('Libelle', $request->input('ClasseLibelle'))->value('id');

            // $existingCourse = Course::where('ProfesseurID', $request->ProfesseurID )
            //     ->where('ModuleID', $request->ModuleId)
            //     ->first();

            // if ($existingCourse) {
            //     return response()->json(['message' => 'Un cours avec ce professeur et ce module existe déjà.'], 400);
            // }

            $course = Course::create([
                'NombreHeuresGlobal' => $request->input('NombreHeuresGlobal'),
                'SemestreID' => $request->SemestreID,
                'ProfesseurID' => $request->ProfesseurID,
                'ModuleID' => $request->ModuleId,
                'ClasseID' => $request->ClasseId,
                'QuotaHoraire' => $request->input('QuotaHoraire'),
            ]);

            return response()->json(['course' => $course], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la création du cours.', 'error' => $e->getMessage()], 500);
        }
    }

    public function getAllLabels()
    {
        $semestres = Semestre::get(['Libelle', 'id']);
        $professeurs = Professeur::get(['Prenom', 'id']);
        $modules = Module::get(['Libelle', 'id']);
        $classes = Classe::get(['Libelle', 'id']);

        return response()->json([
            'semestres' => $semestres,
            'professeurs' => $professeurs,
            'modules' => $modules,
            'classes' => $classes,
        ], 200);
    }
    public function getSall(){
        $salles=Salle::All();
        return ApiResponse::success($salles, 200);
    }

}
