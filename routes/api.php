<?php
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\PatientBiodataController;
use App\Http\Controllers\MedicinesController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\SketchController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\InvestigationController;
use App\Http\Controllers\HMOsController;
use App\Http\Controllers\ManufacturersController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PermissionsController;
use App\Models\Zone;
use App\Models\State;
use App\Models\HMOs;
use App\Models\StatusList;
use App\Models\Languages;
use App\Http\Controllers\HospitalController;
use App\Models\Cancer;
use App\Mail\WelcomeEmail;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController; 
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use App\Http\Controllers\RolesController;
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


Route::get('/visual_acuity_far', [VisualAcuityFarController::class, 'retrieveAll']);
Route::post('/visual_acuity_far', [VisualAcuityFarController::class, 'store']);

Route::get('/visual_acuity_near', [VisualAcuityNearController::class, 'retrieveAll']);
Route::post('/visual_acuity_near', [VisualAcuityNearController::class, 'store']);

Route::get('/refraction_cylinder', [RefractionCylinderController::class, 'retrieveAll']);
Route::post('/refraction_cylinder', [RefractionCylinderController::class, 'store']);

Route::get('/refraction_prism', [RefractionPrismController::class, 'retrieveAll']);
Route::post('/refraction_prism', [RefractionPrismController::class, 'store']);

Route::get('/refraction_axis', [RefractionAxisController::class, 'retrieveAll']);
Route::post('/refraction_axis', [RefractionAxisController::class, 'store']);

Route::get('/refraction_sphere', [RefractionSphereController::class, 'retrieveAll']);
Route::post('/refraction_sphere', [RefractionSphereController::class, 'store']);

Route::get('/diagnosis_list', [DiagnosisListController::class, 'retrieveAll']);
Route::post('/diagnosis_list', [DiagnosisListController::class, 'store']);

Route::get('/chief_complaint', [ChiefComplaintController::class, 'retrieveAll']);
Route::post('/chief_complaint', [ChiefComplaintController::class, 'store']);

Route::get('/doctors', [DoctorsController::class, 'retrieveAll']);
Route::post('/doctors', [DoctorsController::class, 'store']);

Route::get('/hmos', [HMOsController::class, 'retrieveAll']);
Route::post('/hmos', [HMOsController::class, 'store']);

Route::get('/patients', [PatientsController::class, 'retrieveAll']);
Route::get('/patients/search', [PatientsController::class, 'searchPatient']);
Route::post('/patients', [PatientsController::class, 'store']);
Route::get('/patients-all', [PatientsController::class, 'retrieveAllPatients']);
Route::put('/patient/{patientId}', [PatientsController::class, 'update']);
Route::delete('/patient/{patientId}', [PatientsController::class, 'deletePatient']);


// Route::get('/users', [UserController::class, 'retrieveAll']);
Route::post('/sign-up', [UserController::class, 'patientSignUp']);
// Route::get('/users/doctors', [UserController::class, 'doctors']);
// Route::get('/users/nurses', [UserController::class, 'nurses']);
// Route::get('/users/clinic_receptionists', [UserController::class, 'clinic_receptionists']);
// Route::get('/users/workshop_receptionists', [UserController::class, 'workshop_receptionists']);
// Route::get('/users/front_desks', [UserController::class, 'front_desk']);
// Route::delete('/user/{id}', [UserController::class, 'deleteUser']);
// Route::put('/user/{id}', [UserController::class, 'updateUser']);




Route::get('/appointments', [AppointmentsController::class, 'retrieveAll']);
Route::post('/appointments', [AppointmentsController::class, 'store']);
Route::post('/encounter-appointment', [AppointmentsController::class, 'createEncounterAppointment']);
Route::delete('/appointments/{appointmentId}', [AppointmentsController::class, 'deleteAppointment']);
Route::put('/appointments/{appointmentId}', [AppointmentsController::class, 'updateAppointment']);


Route::get('/medicines', [MedicinesController::class, 'retrieveAll']);
Route::post('/medicines', [MedicinesController::class, 'store']);
Route::put('/medicines/{medicineId}', [MedicinesController::class, 'update']);
Route::delete('/medicines/{medicineId}', [MedicinesController::class, 'deleteMedicine']);

Route::get('/manufacturers', [ManufacturersController::class, 'retrieveAll']);
Route::post('/manufacturers', [ManufacturersController::class, 'store']);
Route::put('/manufacturers/{manufacturerId}', [ManufacturersController::class, 'update']);
Route::delete('/manufacturers/{manufacturerId}', [ManufacturersController::class, 'deleteManufacturer']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/patients', [PatientsController::class, 'retrieveAll']);
    Route::get('/hospital/patients', [PatientsController::class, 'hospitalPatients']);
    Route::get('/hospital/doctors', [PatientsController::class, 'hospitalDoctors']);
    Route::post('/patient/doctor/assign', [PatientsController::class, 'assignDoctor']);
    Route::post('/patient/doctor/careplan', [PatientsController::class, 'doctorcarePlan']);
    Route::get('/patient/doctor/all', [PatientsController::class, 'doctorPatients']);
    Route::get('/patient/doctor/reviewed', [PatientsController::class, 'doctorReviewedPatients']);
    Route::get('/patient/doctor/pending', [PatientsController::class, 'doctorPendingPatients']);
    
    Route::get('/patient/social-welfare/all', [PatientsController::class, 'socialWelfarePatients']);
    
    Route::post('/states', function (Request $request) {
        $states = $request->all(); // Expecting an array of states
    
        // Bulk insert
        State::insert($states);
    
        return response()->json([
            'message' => 'States created successfully',
            'data' => $states
        ]);
    });
    
    Route::get('/states', function(){
        $states = State::orderBy('stateName')->get();
        return response()->json([
            'states' => $states
        ]);
    });

    Route::get('/products', [ProductController::class, 'retrieveAll']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'deleteProduct']); 
    
    Route::get('/medicines', [ProductController::class, 'retrieveMedicines']);
    Route::get('/lenses', [ProductController::class, 'retrieveLenses']);
    Route::get('/frames', [ProductController::class, 'retrieveFrames']);
    Route::get('/accessories', [ProductController::class, 'retrieveAccessories']);
   
    Route::get('/services', [ServiceController::class, 'retrieveAll']);
    Route::get('/services', [ServiceController::class, 'retrieveAll']);
    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/services/{id}', [ServiceController::class, 'deleteService']); 
    
    Route::get('/inventories', [InventoryController::class, 'retrieveAll']);
    Route::post('/inventories', [InventoryController::class, 'store']);
    Route::put('/inventories/{id}', [InventoryController::class, 'update']);
    Route::delete('/inventories/{id}', [InventoryController::class, 'deleteInventory']); 
   
    Route::get('/medicine-inventories', [InventoryController::class, 'retrieveMedicines']);
    Route::get('/lenses-inventories', [InventoryController::class, 'retrieveLenses']);
    Route::get('/frames-inventories', [InventoryController::class, 'retrieveFrames']);
    Route::get('/accessories-inventories', [InventoryController::class, 'retrieveAccessories']);

    Route::get('/product-billing-inventories', [InventoryController::class, 'billingInventory']);
    Route::get('/service-billing-inventories', [ServiceController::class, 'serviceInventory']);

    Route::post('/bill-patient', [BillingController::class, 'store']);
    Route::post('/confirm-payment', [BillingController::class, 'updateBillingStatus']);

    Route::get('/billings', [BillingController::class, 'retrieveAll']);
    Route::post('/billings', [BillingController::class, 'store']);
    Route::put('/billings/{id}', [BillingController::class, 'update']);
    Route::delete('/billings', [BillingController::class, 'delete']);

   
    Route::get('/hospitals', [HospitalController::class, 'retrieveAll']);
    Route::post('/hospitals', [HospitalController::class, 'store']);
    
    Route::post('/hospital-users', [UserController::class, 'createHospitalStaff']);
    
    Route::post('/hospital-staff', [UserController::class, 'createHospitalStaff']);
    Route::get('/hospital-staff', [UserController::class, 'hospitalStaff']);
    
    Route::post('/hospital-admins', [UserController::class, 'createHospitalAdmin']);
    Route::get('/hospital-admins', [UserController::class, 'hospitalAdmins']);
    
    Route::post('/nicrat-users', [UserController::class, 'createNicratStaff']);
    
    Route::post('/cmds', [UserController::class, 'createCMD']);
    Route::get('/cmds', [UserController::class, 'cmds']);

    Route::post('/patients/biodata', [PatientBiodataController::class, 'store']);
    Route::get('/patients/biodata/{phoneNumber}', [PatientBiodataController::class, 'retrievePatient']);
    Route::get('patient/{phoneNumber}/status', [PatientBiodataController::class, 'currentStatus']);
    
    Route::post('/doctor-assessment', [DoctorAssessmentController::class, 'RetrieveAll']);
    Route::get('/doctor-assessment', [DoctorAssessmentController::class, 'store']);

    Route::post('/cmd-assessment', [CMDAssessmentController::class, 'RetrieveAll']);
    Route::get('/cmd-assessment', [CMDAssessmentController::class, 'store']);

    Route::post('/mdt-assessment', [MDTAssessmentController::class, 'RetrieveAll']);
    Route::get('/mdt-assessment', [MDTAssessmentController::class, 'store']);

    Route::post('/nicrat-assessment', [NICRATAssessmentController::class, 'RetrieveAll']);
    Route::get('/nicrat-assessment', [NICRATAssessmentController::class, 'store']);

    Route::post('/social-welfare-assessment', [SocialWelfareAssessmentController::class, 'RetrieveAll']);
    Route::get('/social-welfare-assessment', [SocialWelfareAssessmentController::class, 'store']);

    Route::post('/personal-history', [PersonalHistoryController::class, 'RetrieveAll']);
    Route::get('/personal-history', [PersonalHistoryController::class, 'store']);

    Route::post('/family-history', [FamilyHistoryController::class, 'RetrieveAll']);
    Route::get('/family-history', [FamilyHistoryController::class, 'store']);

    Route::post('/social-condition', [SocialCondtionController::class, 'RetrieveAll']);
    Route::get('/social-condition', [SocialCondtionController::class, 'store']);

    
});

Route::get('/roles', [RolesController::class, 'retrieveAll']);
Route::get('/roles/hospital', [RolesController::class, 'hospitalRoles']);
Route::post('/roles', [RolesController::class, 'store']);



Route::get('/user-permissions', [PermissionsController::class, 'getUserPermissions']);
Route::get('/permissions', [PermissionsController::class, 'getPermissions']);
Route::post('/permissions', [PermissionsController::class, 'createPermission']);
Route::post('/assign-role-permissions', [PermissionsController::class, 'assignRoleToPermissions']);

Route::get('/consulting', [ConsultingController::class, 'retrieveAll']);
Route::post('/consulting', [ConsultingController::class, 'store']);

Route::get('/continue_consulting', [ContinueConsultingController::class, 'retrieveAll']);
Route::post('/continue_consulting', [ContinueConsultingController::class, 'store']);

Route::get('/refraction', [RefractionController::class, 'retrieveAll']);
Route::post('/refraction', [RefractionController::class, 'store']);

Route::get('/encounters', [EncountersController::class, 'retrieveAll']);
Route::post('/encounters', [EncountersController::class, 'store']);

Route::get('/diagnosis', [DiagnosisController::class, 'retrieveAll']);
Route::post('/diagnosis', [DiagnosisController::class, 'store']);

Route::post('/sketch', [SketchController::class, 'saveSketches']);

Route::post('/treatment', [TreatmentController::class, 'saveTreatments']);

Route::post('/investigations', [InvestigationController::class, 'store']);



Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->post('/change-password', [AuthController::class, 'changePassword']);
Route::put('/update-profile', [AuthController::class, 'updateProfile']);


Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

Route::get('/test-email', function () {
    try {
        Mail::to('test@example.com')->send(new WelcomeEmail('John', 'Doe', 'test@example.com', 'password123'));
        return 'Email sent!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::post('/geopolitcal-zones', function (Request $request) {
    $zone = $request->all();
    Zone::create($zone);
    return response()->json(['message' => 'Zone created successfully', $zone]);
});

Route::post('/states', function (Request $request) {
    $states = $request->all(); // Expecting an array of states

    // Bulk insert
    State::insert($states);

    return response()->json([
        'message' => 'States created successfully',
        'data' => $states
    ]);
});

Route::get('/states', function(){
    $states = State::orderBy('stateName')->get();
    return response()->json($states);
});

Route::get('/cancers', function(){
    $cancers = Cancer::orderBy('cancerName')->get();
    return response()->json($cancers);
});

Route::post('/cancers', function (Request $request) {
    $cancers = $request->all(); // Expecting an array of states

    // Bulk insert
    Cancer::insert($cancers);

    return response()->json([
        'message' => 'Cancers created successfully',
        'data' => $cancers
    ]);
});


Route::post('/hmos', function (Request $request) {
    $hmos = $request->all(); // Expecting an array of states

    // Bulk insert
    HMOs::insert($hmos);

    return response()->json([
        'message' => 'HMOs created successfully',
        'data' => $hmos
    ]);
});

Route::get('/hmos', function(){
    $hmos = HMOs::orderBy('hmoName')->get();
    return response()->json($hmos);
});


Route::post('/status_list', function (Request $request) {
    $status_list = $request->all(); // Expecting an array of states

    // Bulk insert
    StatusList::insert($status_list);

    return response()->json([
        'message' => 'Status created successfully',
        'data' => $status_list
    ]);
});

Route::get('/status_list', function(){
    $status_list = StatusList::orderBy('statusId')->get();
    return response()->json($status_list);
});


Route::post('/languages', function (Request $request) {
    $languages = $request->all(); // Expecting an array of states

    // Bulk insert
    Languages::insert($languages);

    return response()->json([
        'message' => 'Languages created successfully',
        'data' => $languages
    ]);
});

Route::get('/languages', function(){
    $languages = Languages::orderBy('languageId')->get();
    return response()->json($languages);
});

Route::post('/send-whatsapp', [UserController::class, 'sendSMS']);
// Route::post('/send-whatsapp', 'UserController@sendWhatsAppNotificationSMS');
