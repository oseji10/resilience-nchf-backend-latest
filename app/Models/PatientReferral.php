<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientReferral extends Model
{
    use HasFactory;
    public $table = 'patient_referral';
    protected $primaryKey = 'referralId';
    protected $fillable = [
        'patientUserId',
        'referringHospital',
        'referredHospital',
        'referringDoctor',
        'referredDoctor',
        'referringCMD',
        'referredCMD',
        'appointmentDate',
        'referringDoctorComment',
        'referredDoctorComment',
        'comment',
        'status',

    ];
    
    public function referred_hospital(){
        return $this->belongsTo(Hospital::class, 'referredHospital', 'hospitalId');
    }

    public function user(){
        return $this->belongsTo(User::class, 'patientUserId', 'id');
    }
}
