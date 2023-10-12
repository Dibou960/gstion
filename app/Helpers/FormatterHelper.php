<?php

namespace App\Helpers;

use App\Models\Course;
use App\Models\SessionCours;

class FormatterHelper
{
    public static function formatCourse($course)
    {
        return [
            'id' => $course->id,
            'NombreHeuresGlobal' => $course->NombreHeuresGlobal,
            'QuotaHoraire' => $course->QuotaHoraire,
            'SemestreName' => optional($course->semestre)->Libelle,
            'ProfesseurName' => optional($course->professeur)->Prenom,
            'ModuleName' => optional($course->module)->Libelle,
            'ClasseName' => optional($course->classe)->Libelle,
            'SalleName' => $course->sessions->isNotEmpty() ? optional($course->sessions[0]->salle)->Nom : null,
            'sessions' => self::formatSessions($course->sessions),
        ];
    }

    public static function formatSessions($sessions)
    {
        return $sessions->map(function ($session) {
            return [
                'id' => $session->id,
                'Date' => $session->Date,
                'HeureDebut' => $session->HeureDebut,
                'HeureFin' => $session->HeureFin,
                'NombreHeures' => $session->NombreHeures,
                'salle' => $session->salle,
            ];
        });
    }
    public static function createCourse($validatedData)
    {
        return Course::create([
            'NombreHeuresGlobal' => $validatedData['NombreHeuresGlobal'],
            'SemestreID' => $validatedData['SemestreID'],
            'ProfesseurID' => $validatedData['ProfesseurID'],
            'ModuleID' => $validatedData['ModuleId'],
            'ClasseID' => $validatedData['ClasseId'],
            'QuotaHoraire' => $validatedData['QuotaHoraire'],
        ]);
    }

    public static function createSession($validatedData)
    {
        return SessionCours::create($validatedData);
    }
}
