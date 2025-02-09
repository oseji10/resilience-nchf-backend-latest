<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyHistory extends Model
{
    
    use HasFactory, SoftDeletes;

    protected $table = 'patient_family_history';

    protected $primaryKey = 'familyHistoryId';

    protected $fillable = [
        'patientUserId',
        'familySetupSize',
        'birthOrder',
        'fathersEducationalLevel',
        'mothersEducationalLevel',
        'fathersOccupation',
        'mothersOccupation',
        'levelOfFamilyCare',
        'familyMonthlyIncome',
        'reviewerId',
        'status'
    ];
}
