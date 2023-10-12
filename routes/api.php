<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\AnneeScolaireController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('annees-scolaires')->group(function () {
    Route::get('/', [AnneeScolaireController::class, 'index']); Route::get('/{id}', [AnneeScolaireController::class, 'show']); Route::post('/', [AnneeScolaireController::class, 'store']); Route::put('/{id}', [AnneeScolaireController::class, 'update']); Route::delete('/{id}', [AnneeScolaireController::class, 'destroy']); Route::get('/{id}/classe', [AnneeScolaireController::class, 'getClasseForAnneeScolaire']);
});

Route::prefix('classe')->group(function () {
    Route::get('/', [ClasseController::class, 'index']); Route::get('/{id}', [ClasseController::class, 'show']); Route::post('/', [ClasseController::class, 'store']); Route::put('/{id}', [ClasseController::class, 'update']); Route::delete('/{id}', [ClasseController::class, 'destroy']);
});

Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index']);
    Route::post('/', [CourseController::class, 'store']);
    Route::get('/all-labels', [CourseController::class, 'getAllLabels']);
    Route::get('/modules/{module}', [CourseController::class, 'getProfByModuleID']);
    Route::get('/salles', [CourseController::class, 'getSall']);
});
Route::prefix('sessions')->group(function () {
    Route::post('/', [SessionController::class, 'store']);
});
Route::prefix('students')->group(function () {
    Route::post('/import', [StudentController::class, 'importStudents']);
});

Route::prefix('professeur')->group(function () {
    Route::post('/', [ProfesseurController::class, 'store']);
    Route::get('/', [ProfesseurController::class, 'index']);
    Route::put('/{id}', [ProfesseurController::class, 'update']);
});