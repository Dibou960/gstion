<?php

namespace App\Helpers;

class ValidationRules
{
    public static function validateCourseRequest($request)
    {
        return $request->validate([
            'NombreHeuresGlobal' => 'required|integer',
            'SemestreID' => 'required|string',
            'ProfesseurID' => 'required|string',
            'ModuleId' => 'required|string',
            'ClasseId' => 'required|string',
            'QuotaHoraire' => 'required|integer',
        ]);
    }

    public static function validateSessionRequest($request)
    {
        $validatedData = $request->validate([
            'Date' => 'required|date',
            'HeureDebut' => 'required|string',
            'HeureFin' => 'required|string|after:HeureDebut',
            'NombreHeures' => 'required|integer',
            'SalleID' => 'required|integer',
            'CoursID' => 'required|integer',
        ]);
    }

}
