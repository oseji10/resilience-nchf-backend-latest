<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hospital;
use App\Models\Patient;
use App\Models\User;
use App\Models\ApplicationReview;
use App\Models\StatusList;
use App\Models\PersonalHistory;
use App\Models\FamilyHistory;
use App\Models\SocialCondition;

class PatientBiodataController extends Controller
{
    public function retrievePatient($phoneNumber)
    {
        $user = User::where('phoneNumber', $phoneNumber)->first();
        $patient = Patient::with('hospital', 'stateOfOrigin')->where('userId', $user->id)->first();
        return response()->json($patient); 
       
    }

    public function currentStatus($phoneNumber)
    {
        $user = User::where('phoneNumber', $phoneNumber)->first();
        $current_status = ApplicationReview::where('patientUserId', $user->id)
        ->orderBy('created_at', 'desc')
        ->pluck('statusId')
        ->first();
        
        return response()->json($current_status); 
       
    }


    public function store(Request $request)
    {
        // Validate request data
        $data = $request->all();
    
        // Retrieve hospital data
        $hospital = Hospital::findOrFail($data['hospital']); // Safe fetch
        $uniqueID = substr(md5(uniqid()), 0, 10);
    
        $statusId = StatusList::orderBy('statusId')->skip(1)->value('statusId');

        // Prepare additional fields
        $data['userId'] = Auth::id();
        $data['chfId'] = "CHF-{$hospital->hospitalShortName}-$uniqueID";
        $data['status'] = 2;
        
        // Use `firstOrCreate` to prevent duplicate records
        $patient = Patient::firstOrCreate(
            ['userId' => Auth::id()], // Check condition (unique constraint)
            $data // Insert only if it doesn’t exist
        );


         // Create Patient History
    $patientHistoryData = [
        'patientUserId'         => Auth::id(),
        'averageMonthlyIncome' => $data['averageMonthlyIncome'] ?? null,
        'averageFeedingDaily'   => $data['averageFeedingDaily'] ?? null,
        'whoProvidesFeeding'    => $data['whoProvidesFeeding'] ?? null,
        'accomodation'          => $data['accomodation'] ?? null,
        'typeOfAccomodation'    => $data['typeOfAccomodation'] ?? null,
        'noOfGoodSetOfClothes'  => $data['noOfGoodSetOfClothes'] ?? null,
        'howAreClothesGotten'   => $data['howAreClothesGotten'] ?? null,
        'whyDidYouChooseHospital' => $data['whyDidYouChooseHospital'] ?? null,
        'hospitalReceivingCare' => $data['hospitalReceivingCare'] ?? null,
        'levelOfSpousalSpupport' => $data['levelOfSpousalSpupport'] ?? null,
        'otherSupport'          => $data['otherSupport'] ?? null,
        
    ];

    $patientHistory = PersonalHistory::firstOrCreate(['patientUserId' => Auth::id()], // Check condition (unique constraint)
    $patientHistoryData);

 // Store Family History
 $familyData = [
    'patientUserId'           => Auth::id(),
    'familySetupSize'         => $data['familySetupSize'] ?? null,
    'birthOrder'              => $data['birthOrder'] ?? null,
    'fathersEducationalLevel' => $data['fathersEducationalLevel'] ?? null,
    'mothersEducationalLevel' => $data['mothersEducationalLevel'] ?? null,
    'fathersOccupation'       => $data['fathersOccupation'] ?? null,
    'mothersOccupation'       => $data['mothersOccupation'] ?? null,
    'levelOfFamilyCare'       => $data['levelOfFamilyCare'] ?? null,
    'familyMonthlyIncome'     => $data['familyMonthlyIncome'] ?? null,
];

$familyHistory = FamilyHistory::firstOrCreate(
    ['patientUserId' => Auth::id()],  // Prevent duplicate records
    $familyData
);
    


    // Store Living Conditions
    $livingConditionData = [
        'patientUserId'     => Auth::id(),
        'runningWater'      => $data['runningWater'] ?? null,
        'toiletType'        => $data['toiletType'] ?? null,
        'powerSupply'       => $data['powerSupply'] ?? null,
        'meansOfTransport'  => $data['meansOfTransport'] ?? null,
        'mobilePhone'       => $data['mobilePhone'] ?? null,
        'howPhoneIsRecharged' => $data['howPhoneIsRecharged'] ?? null,
    ];

    $livingCondition = SocialCondition::firstOrCreate(
        ['patientUserId' => Auth::id()],  // Prevent duplicate records
        $livingConditionData
    );
        $status_data['patientUserId'] = Auth::id();
        $status_data['reviewerId'] = Auth::id();
        $status_data['reviewerRole'] = 1;
        $status_data['statusId'] = $statusId;

        $application_status = ApplicationReview::firstOrCreate(['patientUserId' => Auth::id()], // Check condition (unique constraint)
        $status_data);


        // Check if the record already existed
        if (!$patient->wasRecentlyCreated) {
            return response()->json(['error' => 'You have already started an application'], 409);
        }
    
        return response()->json($patient, 201); // 201: Created
    }
    
    
}
