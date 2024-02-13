<?php

namespace App\Http\Controllers;

use App\Models\Nurse;
use App\Models\Patient;
use App\Models\VisitReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DataController extends Controller
{
    /**
     * View all nurses for doctor
     * @param int $doctorId
     * @return JsonResponse
     */
    public function viewAllNursesByDoctor(int $doctorId):JsonResponse
    {
        $nurses = Nurse::with('user')
            ->with('doctor')
            ->with('visits')
            ->where('doctor_id', $doctorId)
            ->get();

        return response()->json([
            "status"=>"success",
            "nurses"=>$nurses
        ]);
    }

    /**
     * View all patients
     * @param int $doctorId
     * @return JsonResponse
     */
    public function viewAllPatientsByDoctor(int $doctorId):JsonResponse
    {
        $patients= Patient::with('doctor')
            ->with('visits')
            ->where('doctor_id', $doctorId)
            ->get();

        return response()->json([
            "status"=>"success",
            "patients"=>$patients
        ]);
    }

    /**
     * View all patients
     * @param int $doctorId
     * @return JsonResponse
     */

    public function viewAllReportByDoctor(int $doctorId):JsonResponse
    {
        $reports = VisitReport::with('nurse')
            ->with('visits.treatments')
            ->with('visits.patient')
            ->where('doctor_id', $doctorId)
            ->get();
        return response()->json([
            "status"=>"success",
            "reports"=>$reports
        ]);
    }



}
