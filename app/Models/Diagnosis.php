<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;
    public $table = 'diagnosis';
    protected $fillable = [
        'patientId',
        'encounterId',
        'diagnosisLeft',
        'diagnosisRight'
    ];
    protected $primaryKey = 'diagnosisId';
    public function encounters()
    {
        return $this->belongsTo(Encounters::class, 'encounterId', 'encounterId');
    }

    public function patients()
    {
        return $this->hasMany(Patients::class, 'patientId', 'patientId');
    }

    public function diagnosisRightDetails()
    {
        return $this->belongsTo(DiagnosisList::class, 'diagnosisRight');
    }

    public function diagnosisLeftDetails()
    {
        return $this->belongsTo(DiagnosisList::class, 'diagnosisLeft');
    }
}
