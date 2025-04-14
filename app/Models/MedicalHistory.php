<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;
    public $table = 'patient_medical_history';
    protected $primaryKey = 'medicalHistoryId';
    protected $fillable = [
    // 'medicalHistoryId',
    'patientUserId',
    'hospitalId',
    'addedBy',
    'history',
    ];

    public function item(){
        return $this->hasMany(PrescriptionItem::class, 'prescriptionId');
    }

    public function items(){
        return $this->hasMany(PrescriptionItem::class, 'prescriptionId');
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientId');
    }
}
