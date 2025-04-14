<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientReferralService extends Model
{
    use HasFactory;
    public $table = 'patient_referral_services';
    // protected $primaryKey = 'id';
    protected $fillable = [
        'patientUserId',
        'serviceId',
        'hospitalId',
        'referralId',
        'status',
    ];
    
}
