<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['cors'])->group(function (){

    /**
     * =================== ROUTE POST ==================
    */

    //Route pour l'enregistrement d'un nouveau medecin ::tested
    Route::post('/doctor.register', [\App\Http\Controllers\AppController::class, 'doctorRegister']);

    //Route pour la creation d'un Infirmier par un medecin ::tested
    Route::post('/nurse.create', [\App\Http\Controllers\AppController::class, 'createNurse']);

    //Route pour l'authentification ::tested
    Route::post('/login', [\App\Http\Controllers\AppController::class, 'login']);

    //Route pour la creation d'un patient par un docteur ::tested
    Route::post('/patient.create', [\App\Http\Controllers\AppController::class, 'createPatient']);

    //Route pour la programmation ou creation d'une visite par le docteur ::tested
    Route::post('/visit.create', [\App\Http\Controllers\AppController::class, 'createVisit']);

    //Route pour valider une visite effectuée  ::tested
    Route::post('/visit.validate', [\App\Http\Controllers\AppController::class, 'completeVisit']);

    //Route pour deleguer une visite à un autre collegue en attente de la confirmation du medecin ::tested
    Route::post('/visit.delegate', [\App\Http\Controllers\AppController::class, 'delegateVisitToOtherNurse']);

    //==================== GET DATA ====================//

    //Voir tous les infirmier du medecin ::tested
    Route::get('/nurses.all/{doctorId}', [\App\Http\Controllers\DataController::class, 'viewAllNursesByDoctor']);

    //voir tous les patients du médecin ::tested
    Route::get('/patients.all/{doctorId}', [\App\Http\Controllers\DataController::class, 'viewAllPatientsByDoctor']);

    //Voir le rapport pour le medecin ::tested
    Route::get('/doctor.reports/{period}/{doctorId}', [\App\Http\Controllers\DataController::class, 'generateReportByPeriodForDoctor']);


    //Voir toutes les visites/agenda créées par un medecin
    Route::get('/doctor.visites/{doctorId}', [\App\Http\Controllers\DataController::class, 'viewAllVisitsByDoctor']);

    //Voir l'agenda d'acceuil de l'Infirmier(les visites et visites deleguées) ::tested
    Route::get('/nurse.agenda/{nurseId}', [\App\Http\Controllers\DataController::class, 'viewHomeVisitsByNurse']);

    //Voir le rapport pour les infirmiers ::tested
    Route::get('/nurse.reports/{period}/{nurseId}', [\App\Http\Controllers\DataController::class, 'generateReportByPeriodForNurse']);

    //Voir l'agenda filtré par date de l'infirmier
    Route::get('/nurse.schedules/{nurseId}/{date?}', [\App\Http\Controllers\DataController::class, 'viewNurseSchedule']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
