<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encounters;
use App\Models\VisualAcuityFar;
use App\Models\Patients;

class EncountersController extends Controller
{
//     public function RetrieveAll()
//     {
//         // $encounters = Encounters::with('patients', 'continue_consulting', 'consulting.visualAcuityFarPresentingRight', 'consulting.visualAcuityFarPresentingLeft')->get();
//         $encounters = Encounters::select(
//             'patients.patientId',
//             'patients.firstName',
//             'patients.lastName',
//             'patients.gender',
//             'patients.bloodGroup',
//             'patients.occupation',
//             'encounters.encounterId',
//             'encounters.created_at',
//             'encounters.status',
            
//             'visual_acuity_far_right.name as visualAcuityFarPresentingRight', 
//             'visual_acuity_far_left.name as visualAcuityFarPresentingLeft',  
//             'visual_acuity_far__pinhole_right.name as visualAcuityFarPinholeRight',  
//             'visual_acuity_far__pinhole_left.name as visualAcuityFarPinholeLeft',  
//             'visual_acuity_far_best_corrected_right.name as visualAcuityFarBestCorrectedRight',  
//             'visual_acuity_far_best_corrected_left.name as visualAcuityFarBestCorrectedLeft',  
//             'visual_acuity_near_right.name as visualAcuityNearRight', 
//             'visual_acuity_near_left.name as visualAcuityNearLeft', 
            
//             'continue_consulting.intraOccularPressureRight',
//             'continue_consulting.intraOccularPressureLeft',
//             'continue_consulting.otherComplaintsRight',
//             'continue_consulting.otherComplaintsLeft',
//             'continue_consulting.detailedHistoryRight',
//             'continue_consulting.detailedHistoryLeft',
//             'continue_consulting.findingsRight',
//             'continue_consulting.findingsLeft',
//             'continue_consulting.eyelidRight',
//             'continue_consulting.eyelidLeft',
//             'continue_consulting.conjunctivaRight',
//             'continue_consulting.conjunctivaLeft',
//             'continue_consulting.corneaRight',
//             'continue_consulting.corneaLeft',
//             'continue_consulting.ACRight',
//             'continue_consulting.ACLeft',
//             'continue_consulting.irisRight',
//             'continue_consulting.irisLeft',
//             'continue_consulting.pupilRight',
//             'continue_consulting.pupilLeft',
//             'continue_consulting.lensRight',
//             'continue_consulting.lensLeft',
//             'continue_consulting.vitreousRight',
//             'continue_consulting.vitreousLeft',
//             'continue_consulting.retinaRight',
//             'continue_consulting.retinaLeft',
//             'continue_consulting.otherFindingsRight',
//             'continue_consulting.otherFindingsLeft',
//             'chief_complaint_right.name as chiefComplaintRight', 
//             'chief_complaint_left.name as chiefComplaintLeft', 
            
//             'refractions.nearAddRight', 
//             'refractions.nearAddLeft',  
//             'refractions.OCTRight',  
//             'refractions.OCTLeft',  
//             'refractions.FFARight',  
//             'refractions.FFALeft',  
//             'refractions.fundusPhotographyRight', 
//             'refractions.fundusPhotographyLeft', 
//             'refractions.pachymetryRight', 
//             'refractions.pachymetryLeft',  
//             'refractions.CUFTRight',  
//             'refractions.CUFTLeft',  
//             'refractions.CUFTKineticRight',  
//             'refractions.CUFTKineticLeft',  
//             'refractions.pupilRight as pupilDistanceRight', 
//             'refractions.pupilLeft as pupilDistanceLeft',
//             'refractions.refractionSphereRight', 
//             'refractions.refractionSphereLeft',  
//             'refractions.refractionCylinderRight',  
//             'refractions.refractionCylinderLeft',  
//             'refractions.refractionAxisRight',  
//             'refractions.refractionAxisLeft',  
//             'refractions.refractionPrismRight', 
//             'refractions.refractionPrismLeft',

//             'diagnosis_right.name as diagnosisRight', 
//             'diagnosis_left.name as diagnosisLeft',
            
//             'investigations.investigationsRequired',  
//             'investigations.externalInvestigationRequired', 
//             'investigations.investigationsDone',
//             'investigations.HBP', 
//             'investigations.diabetes',  
//             'investigations.pregnancy',  
//             'investigations.drugAllergy',  
//             'investigations.currentMedication',  
//             'uploaded_document_url.fileUrl as documentId',

//             'treatment.treatmentType',  
//             'treatment.dosage', 
//             'treatment.doseDuration',
//             'treatment.doseInterval', 
//             'treatment.time',  
//             'treatment.comment',  
//             'treatment.lensType',  
//             'treatment.costOfLens',
//             'treatment.costOfFrame'
         
//         )
//         ->leftjoin('patients', 'patients.patientId', '=', 'encounters.patientId')
//         ->leftjoin('consulting', 'consulting.consultingId', '=', 'encounters.consultingId')
//         ->leftjoin('continue_consulting', 'continue_consulting.continueConsultingId', '=', 'encounters.continueConsultingId')
//         ->leftjoin('refractions', 'refractions.refractionId', '=', 'encounters.refractionId')
//         ->leftjoin('diagnosis', 'diagnosis.diagnosisId', '=', 'encounters.diagnosisId')
//         ->leftjoin('investigations', 'investigations.investigationId', '=', 'encounters.investigationId')
//         ->leftjoin('treatment', 'treatment.treatmentId', '=', 'encounters.treatmentId')

//         ->leftJoin('visual_acuity_far as visual_acuity_far_right', 'visual_acuity_far_right.id', '=', 'consulting.visualAcuityFarPresentingRight')
//         ->leftJoin('visual_acuity_far as visual_acuity_far_left', 'visual_acuity_far_left.id', '=', 'consulting.visualAcuityFarPresentingLeft')
//         ->leftJoin('visual_acuity_far as visual_acuity_far__pinhole_right', 'visual_acuity_far__pinhole_right.id', '=', 'consulting.visualAcuityFarPinholeRight')
//         ->leftJoin('visual_acuity_far as visual_acuity_far__pinhole_left', 'visual_acuity_far__pinhole_left.id', '=', 'consulting.visualAcuityFarPinholeLeft')
//         ->leftJoin('visual_acuity_far as visual_acuity_far_best_corrected_right', 'visual_acuity_far_best_corrected_right.id', '=', 'consulting.visualAcuityFarBestCorrectedRight')
//         ->leftJoin('visual_acuity_far as visual_acuity_far_best_corrected_left', 'visual_acuity_far_best_corrected_left.id', '=', 'consulting.visualAcuityFarBestCorrectedLeft')
//         ->leftJoin('visual_acuity_near as visual_acuity_near_right', 'visual_acuity_near_right.id', '=', 'consulting.visualAcuityNearRight')
//         ->leftJoin('visual_acuity_near as visual_acuity_near_left', 'visual_acuity_near_left.id', '=', 'consulting.visualAcuityNearLeft')
        
//         ->leftJoin('chief_complaint as chief_complaint_right', 'chief_complaint_right.id', '=', 'continue_consulting.chiefComplaintRight')
//         ->leftJoin('chief_complaint as chief_complaint_left', 'chief_complaint_left.id', '=', 'continue_consulting.chiefComplaintLeft')
//         ->leftJoin('document_upload as uploaded_document_url', 'uploaded_document_url.documentId', '=', 'investigations.documentId')

        
// ->leftJoin('diagnosis_list as diagnosis_right', 'diagnosis_right.id', '=', 'diagnosis.diagnosisRight')
// ->leftJoin('diagnosis_list as diagnosis_left', 'diagnosis_left.id', '=', 'diagnosis.diagnosisLeft')
     

//         ->get();
        
//         return response()->json($encounters); 
       
//     }


     public function RetrieveAll()
     {
                    // $encounters = Encounters::query()
                    // // select('user_course_informations.course_id', 'user_course_informations.title')
                    // ->join('consulting', 'consulting.consultingId', '=', 'encounters.consultingId')
                    // // ->where('user_courses.user_id', '=', Auth::guard('web')->user()->id)
                    // // ->where('user_courses.website_id', '=', $this->userBs->id)
                    // ->get();
                   
                    //  $encounters = Patients::where('patientId', '=', '2147483647')->get();
                    return $encounters = Patients::whereHas('encounters') // Filters patients who have encounters
                    ->with([
                        'encounters.consulting.visualAcuityFarPresentingRight',
                        'encounters.consulting.visualAcuityFarPresentingLeft',
                            'encounters.consulting.visualAcuityFarPinholeRight',
                            'encounters.consulting.visualAcuityFarPinholeLeft',
                            'encounters.consulting.visualAcuityFarBestCorrectedRight',
                            'encounters.consulting.visualAcuityFarBestCorrectedLeft',
                            'encounters.consulting.visualAcuityNearRight',
                            'encounters.consulting.visualAcuityNearLeft',
                            'encounters.continueConsulting.chiefComplaintRight',
                            'encounters.continueConsulting.chiefComplaintLeft',
                            'encounters.refractions.sphereRight',
                            'encounters.refractions.sphereLeft',
                            'encounters.refractions.cylinderRight',
                            'encounters.refractions.cylinderLeft',
                            'encounters.refractions.axisRight',
                            'encounters.refractions.axisLeft',
                            'encounters.refractions.prismRight',
                            'encounters.refractions.prismLeft',
                            'encounters.sketches',
                            'encounters.diagnoses.diagnosisRightDetails',
                            'encounters.diagnoses.diagnosisLeftDetails',
                            'encounters.appointments',
                            'encounters.investigations',
                            'encounters.treatments',
                    ])
                    //  ->where('patientId', '=', '113')
                    ->get();
                
                         // 'encounters',
                        // 'encounters.continueConsulting',
                        // 'encounters.refractions',
                        // 'encounters.diagnoses',
                        // 'encounters.investigations',
                        // 'encounters.treatments',

                    // $encounters = Encounters::with([
                    //     'patients',
                    //     'consulting.visualAcuityFarPresentingRight',
                    //     'consulting.visualAcuityFarPresentingLeft',
                    //     'consulting.visualAcuityFarPinholeRight',
                    //     'consulting.visualAcuityFarPinholeLeft',
                    //     'consulting.visualAcuityFarBestCorrectedRight',
                    //     'consulting.visualAcuityFarBestCorrectedLeft',
                    //     'consulting.visualAcuityNearRight',
                    //     'consulting.visualAcuityNearLeft',
                    //     'continueConsulting.chiefComplaintRight',
                    //     'continueConsulting.chiefComplaintLeft',
                    //     'refractions.sphereRight',
                    //     'refractions.sphereLeft',
                    //     'refractions.cylinderRight',
                    //     'refractions.cylinderLeft',
                    //     'refractions.axisRight',
                    //     'refractions.axisLeft',
                    //     'refractions.prismRight',
                    //     'refractions.prismLeft',
                    //     'sketches',
                    //     'diagnoses.diagnosisRightDetails',
                    //     'diagnoses.diagnosisLeftDetails',
                    //     'appointments',
                    //     'investigations',
                    //     'treatments',
                    // ])->get();
                    
                    // return response()->json($encounters, 200);
                         
     }

    public function store(Request $request)
    {
        // Retrieve all data from the request
        $data = $request->all();
    
        // Validate incoming request data (optional but recommended)
        // $validated = $request->validate([
        //     'patientId' => 'required|integer', // Example fields, adjust based on your schema
        //     'details' => 'nullable|string',    // Example field for consulting
        // ]);
    
        // Create a new consulting record
        $consulting = Consulting::create($data);
    
        // Create a new encounter record and link the consultingId
        $encounter = Encounters::create([
            'patientId' => $validated['patientId'],
            'consultingId' => $consulting->consultingId, // Link the consultingId
        ]);
    
        // Update the consulting record with the encounterId
        $consulting->update([
            'encounterId' => $encounter->encounterId, // Link the encounterId
        ]);
    
        // Return the newly created encounter and consulting as JSON response
        return response()->json([
            'message' => 'Encounter and Consulting records created and linked successfully.',
            'encounter' => $encounter,
            'consulting' => $consulting,
        ], 201); // HTTP status code 201: Created
    }
    
    
}
