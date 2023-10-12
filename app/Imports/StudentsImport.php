<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Assurez-vous d'ajuster les clés du tableau en fonction de vos données dans le fichier Excel
        return new Student([
            'Prenom' => $row['Prenom'],
            'Nom' => $row['Nom'],
            'ClasseID' => $row['ClasseID'], 
        ]);
    }
}
