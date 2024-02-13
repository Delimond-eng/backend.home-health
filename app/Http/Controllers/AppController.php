<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\PatientTreatment;
use App\Models\User;
use App\Models\Visit;
use App\Models\VisitDelegate;
use App\Models\VisitReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    /**
     * Create new doctor
     * @param Request $request
     * @author Gaston delimond
     * @return JsonResponse
     */
    public function doctorRegister(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                "name" => "required|string",
                "nickname" => "required|string",
                "hospital" => "required|string",
                "order_num" => "required|string|unique:doctors,doctor_order_num",
                "phone" => "required|string|unique:doctors,doctor_phone",
                "email" => "required|email|unique:users,email",
                "password" => "required|string",
            ]);
            $doctor = Doctor::create([
                "doctor_name" => $data["name"],
                "doctor_nickname" => $data["nickname"],
                "doctor_phone" => $data["phone"],
                "doctor_hospital"=>$data["hospital"],
                "doctor_order_num"=>$data["order_num"],
            ]);
            $user = User::create([
                'email' => $data['email'],
                'password' =>bcrypt($data['password']),
                'profile_id'=>$doctor->id,
                'profile_type'=>'App\Models\Doctor'
            ]);
            $doctor['user']= $user;
            return response()->json([
                "status" => "success",
                "doctor" => $doctor,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['errors' => $e->getMessage()]);
        }
    }


    /**
     * Create new nurse
     * @param Request $request
     * @author Gaston delimond
     * @return JsonResponse
     */
    public function createNurse(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                "name"=>"required|string",
                "nickname"=>"required|string",
                "phone"=>"required|string|unique:nurses,nurse_phone",
                "email"=>"required|email|unique:users,email",
                "password"=>"required|string",
                "doctor_id"=>"required|int|exists:doctors,id",
            ]);
            $nurse = Nurse::create([
                "nurse_name"=>$data["name"],
                "nurse_nickname"=>$data["nickname"],
                "nurse_phone"=>$data["phone"],
                "doctor_id"=>$data["doctor_id"]
            ]);
            $user = User::create([
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'profile_id'=>$nurse->id,
                'profile_type'=>'App\Models\Nurse'
            ]);
            $nurse['user'] = $user;
            return response()->json([
                "status"=>"success",
                "nurse"=>$nurse
            ]);
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }
    }



    /**
     * Login user with specified profile
     * @param Request $request
     * @author Gaston delimond
     * @return JsonResponse
     */
    public function login(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                "email"=>"required|email",
                "password"=>"required|string"
            ]);
            $credentials = $request->only('email', 'password');
            if(Auth::attempt($credentials)){
                $user = Auth::user();
                if ($user->profile_type === 'App\\Models\\Doctor') {
                    $doctorData = $user->profile;
                    return response()->json([
                        "status"=>"success",
                        "user"=>[
                            "name"=>$doctorData['doctor_name'],
                            "nickname"=>$doctorData['doctor_nickname'],
                            "phone"=>$doctorData['doctor_phone'],
                            "status"=>$doctorData['doctor_status'],
                            "profile"=>"doctor"
                        ]
                    ]);
                } else if ($user->profile_type === 'App\\Models\\Nurse') {
                    $nurseData = $user->profile;
                    return response()->json([
                        "status"=>"success",
                        "user"=>[
                            "name"=>$nurseData['nurse_name'],
                            "nickname"=>$nurseData['nurse_nickname'],
                            "phone"=>$nurseData['nurse_phone'],
                            "status"=>$nurseData['nurse_status'],
                            "doctor_id"=>$nurseData['doctor_id'],
                            "profile"=>"nurse"
                        ]
                    ]);
                } else {
                    return response()->json([
                        "errors"=>"Utilisateur incorrect ! "
                    ]);
                }
            }
            else{
                return response()->json([
                    "errors"=>"Echec de l'Authentification,email ou mot de passe incorrect ! "
                ]);
            }
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }
    }

    /**
     * Create patient with treatments
     * @param Request $request
     * @author Gaston delimond
     * @return JsonResponse
     */
    public function createPatient(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                "name"=>"required|string",
                "nickname"=>"required|string",
                "phone"=>"required|string|unique:patients,patient_phone",
                "address"=>"required|string",
                "gender"=>"required|string",
                "doctor_id"=>"required|int|exists:doctors,id",
            ]);
            $lastPatient = Patient::create([
                "patient_name"=>$data["name"],
                "patient_nickname"=>$data["nickname"],
                "patient_phone"=>$data["phone"],
                "patient_address"=>$data["address"],
                "patient_gender"=>$data["gender"],
            ]);
            return response()->json([
                "status"=>"success",
                "patient"=>$lastPatient
            ]);
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }
    }


    /**
     * Create Visits
     * @author Gaston delimond
     * @param Request $request
     * @return JsonResponse
    */
    public function createVisit(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                "visit_date"=>"required|date_format:Y-m-d",
                "nurse_id"=>"required|int|exists:nurses,id",
                "patient_id"=>"required|int|exists:patients,id",
                "visit_id"=>"nullable|int|exists:visits,id",
                "treatments" => "required|array"
            ]);
            if(isset($data['visit_id'])){
                foreach ($data["treatments"] as $val){
                    $singleTreatment= PatientTreatment::create([
                        "patient_treatment_libelle"=>$val["libelle"],
                        "visit_id"=>$data["visit_id"]
                    ]);
                }
            }
            else{
                $lastVisit = Visit::create([
                    "visit_date"=>$data["visit_date"],
                    "nurse_id"=>$data["nurse_id"],
                    "patient_id"=>$data["patient_id"]
                ]);
                if(isset($lastVisit)){
                    if(isset($data["treatments"])){
                        $visitTreatments = $data["treatments"];
                        foreach ($visitTreatments as $val){
                            $singleTreatment= PatientTreatment::create([
                                "patient_treatment_libelle"=>$val["libelle"],
                                "visit_id"=>$lastVisit->id
                            ]);
                        }
                    }
                    return response()->json([
                        "status"=>"success",
                        "data"=>$lastVisit
                    ]);
                }

            }
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }
    }


    /**
     * Allow to delegate some visit
     * @author Gaston delimond
     * @param Request $request
     * @return JsonResponse
    */
    public function delegateTreatmentToOtherNurse(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                "nurse_id"=>"required|int|exists:nurses,id",
                "visit_id"=>"required|int|exists:visit_delegates,id"
            ]);

            $delegate= VisitDelegate::create([
                "delegate_nurse_id"=>$data["nurse_id"],
                "visit_id"=>$data["visit_id"]
            ]);
            if (isset($delegate)){
                $visit = Visit::find((int)$data["visit_id"]);
                $visit->visit_status = "delegated";
                $visit->save();
                return response()->json([
                    "status"=>"success",
                    "data"=>$delegate
                ]);
            }
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }
    }


    /**
     * Complete pending visit treatment
     * @author Gaston delimond
     * @param Request $request
     * @return JsonResponse
    */
    public function completeVisit(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                "visit_id"=>"required|int|exists:visits,id",
                "nurse_id"=>"required|int|exists:nurses,id",
                "treatments"=>"required|array"
            ]);
            $nurse = Nurse::find((int)$data['nurse_id']);
            $report = VisitReport::create([
                "visit_id"=>$data["visit_id"],
                "nurse_id"=>$data["nurse_id"],
                "doctor_id"=>$nurse->doctor_id
            ]);
            if (isset($report)){
                foreach ($data["treatments"] as $value){
                    PatientTreatment::where('id', (int)$value['id'])->update([
                        'patient_treatment_status'=>'completed'
                    ]);
                }
                return response()->json([
                    "status"=>"success",
                    "report"=>$report
                ]);
            }

        }
        catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }
    }

}
