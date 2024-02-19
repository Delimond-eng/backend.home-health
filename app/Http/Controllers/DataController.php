<?php

namespace App\Http\Controllers;

use App\Models\Nurse;
use App\Models\Patient;
use App\Models\Visit;
use App\Models\VisitDelegate;
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
            ->with('visits.patient')
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
            ->with('visits.treatments')
            ->where('doctor_id', $doctorId)
            ->get();
        return response()->json([
            "status"=>"success",
            "patients"=>$patients
        ]);
    }

    /**
     * View all reports
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


    /**
     * View all visits create by doctor
     * @author Gaston Delimond
     * @param int $doctorId
     * @return JsonResponse
    */
    public function viewAllVisitsByDoctor(int $doctorId):JsonResponse
    {
        $visits  = Visit::with("nurse")
            ->with("patient")
            ->with("treatments")
            ->where('doctor_id', $doctorId)
            ->get();
        return response()->json([
            "status"=>"success",
            "visits"=> $visits
        ]);
    }


    /**
     * View Home visits agenda by nurse
     * @author Gaston Delimond
     * @param int $nurseId
     * @return JsonResponse
    */
    public function viewHomeVisitsByNurse(int $nurseId):JsonResponse
    {
        $visits = Visit::with("nurse")
            ->with("patient")
            ->with("treatments")
            ->where('nurse_id', $nurseId)
            ->get();

        $visitsDelegates= VisitDelegate::with("nurse_delegate")
            ->with("visit.patient")
            ->with("visit.nurse")
            ->with("visit.treatments")
            ->where('delegate_nurse_id', $nurseId)
            ->get();

        return response()->json([
            "status"=>"success",
            "response"=>[
                "delegates"=>$visitsDelegates,
                "visits"=>$visits
            ]
        ]);
    }


    /**
     * view Nurse Done visit
     * @param int $nurseId
     * @author Gaston delimond
     * @return JsonResponse
    */
    public function viewDoneVisitsByNurse(int $nurseId):JsonResponse
    {
        $visitsDone = Visit::with('nurse')
            ->with('patient')
            ->with('treatments')
            ->where('nurse_id', $nurseId)
            ->where('visit_status','completed')
            ->get();
        return response()->json([
            "status"=>"success",
            "done_visits"=>$visitsDone
        ]);
    }


    /**
     * Generate report by period for Doctor
     * @param $period
     * @param $doctorId
     * @return JsonResponse
     */
    public function generateReportByPeriodForDoctor($period, $doctorId):JsonResponse
    {
        $startDate = null;
        $endDate = null;
        switch ($period) {
            case 'day':
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;

            case 'week':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;

            case 'month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;

            default:
                break;
        }
        if($period == "all"){
            $reports = VisitReport::with('nurse')
                ->with('visit.treatments')
                ->with('visit.patient')
                ->where('doctor_id', $doctorId)
                ->get();
        }
        else{
            $reports = VisitReport::with('nurse')
                ->with('visit.treatments')
                ->with('visit.patient')
                ->where('doctor_id', $doctorId)
                ->whereBetween('report_created_at', [$startDate, $endDate])->get();
        }
        return response()->json([
            "status"=>"success",
            "reports"=>$reports
        ]);

    }


    /**
     * Generate report by period for Doctor
     * @param $period
     * @param $nurseId
     * @return JsonResponse
     */
    public function generateReportByPeriodForNurse($period, $nurseId):JsonResponse
    {
        $startDate = null;
        $endDate = null;
        switch ($period) {
            case 'day':
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;

            case 'week':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;

            case 'month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;

            default:
                break;
        }
        $reports = null;
        if($period == "all"){
            $reports = VisitReport::with('nurse')
                ->with('visit.treatments')
                ->with('visit.patient')
                ->where('nurse_id', $nurseId)
                ->get();
        }
        else{
            $reports = VisitReport::with('nurse')
                ->with('visit.treatments')
                ->with('visit.patient')
                ->where('nurse_id', $nurseId)
                ->whereBetween('report_created_at', [$startDate, $endDate])->get();
        }
        return response()->json([
            "status"=>"success",
            "reports"=>$reports
        ]);

    }


    /**
     * View nurse schedule by date
     * @param int $nurseId
     * @param string|null $date
     * @return JsonResponse
     * @author Gaston delimond
     */
    public function viewNurseSchedule(int $nurseId,string $date=null): JsonResponse
    {
        $dateNow = now()->toDateString();
        $date = $date ?? $dateNow;

        $schedules = Visit::with('nurse')
            ->with('patient')
            ->with('treatments')
            ->whereDate('visit_date', $date)
            ->where('nurse_id', $nurseId)
            ->get();

        return response()->json([
            "status" => "success",
            "schedules" => $schedules
        ]);
    }

}
