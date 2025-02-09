<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PersonalHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'patient_personal_history';

    protected $primaryKey = 'personalHistoryId';

    protected $fillable = [
        'patientUserId',
        'averageMonthlyIncome',
        'averageFeedingDaily',
        'whoProvidesFeeding',
        'accomodation',
        'typeOfAccomodation',
        'noOfGoodSetOfClothes',
        'howAreClothesGotten',
        'whyDidYouChooseHospital',
        'hospitalReceivingCare',
        'levelOfSpousalSpupport',
        'otherSupport',
        'reviewerId',
        'status'
    ];

}
