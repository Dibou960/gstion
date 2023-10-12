<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function importStudents(Request $request)
    {
        $file = $request->file('file');

        Excel::import(new StudentsImport, $file);

        return redirect()->route('students.index')
            ->with('success', 'Les étudiants ont été importés avec succès.');
    }
}
