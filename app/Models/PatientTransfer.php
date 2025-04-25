<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTransfer extends Model
{
    use HasFactory;
    public $table = 'patient_transfer';
    protected $primaryKey = 'transferId';
    protected $fillable = [
        'patientUserId',
        'transferringHospital',
        'transferredHospital',
        'transferringDoctor',
        'transferredDoctor',
        'transferringCMD',
        'transferredCMD',
        'appointmentDate',
        'transferringDoctorComment',
        'transferredDoctorComment',
        'comment',
        'status',
    ];
    

    public function transferred_hospital(){
        return $this->belongsTo(Hospital::class, 'transferredHospital', 'hospitalId');
    }

    public function user(){
        return $this->belongsTo(User::class, 'patientUserId', 'id');
    }
}
