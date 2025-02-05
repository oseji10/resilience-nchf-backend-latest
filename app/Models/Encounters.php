<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encounters extends Model
{
    use HasFactory;
    public $table = 'encounters';
    protected $fillable = ['patientId', 'consultingId', 'continueConsultingId', 'refractionId', 'appointmentId', 'investigationId', 'treatmentId', 'diagnosisId', 'sketchId', 'status'];
    protected $primaryKey = 'encounterId';

    public function consulting()
    {
        return $this->hasOne(Consulting::class, 'consultingId', 'consultingId');
    }

    public function continueConsulting()
    {
        return $this->hasOne(ContinueConsulting::class, 'continueConsultingId', 'continueConsultingId');
    }

    public function refractions()
    {
        return $this->hasOne(Refraction::class, 'refractionId', 'refractionId');
    }

    public function diagnoses()
    {
        return $this->hasOne(Diagnosis::class, 'diagnosisId', 'diagnosisId');
    }

    public function patients()
    {
        return $this->hasOne(Patients::class, 'patientId', 'patientId');
    }

    public function sketches()
    {
        return $this->hasOne(Sketch::class, 'encounterId');
    }


    public function appointments()
    {
        return $this->hasOne(Appointments::class, 'encounterId');
    }

    public function investigations()
    {
        return $this->hasOne(Investigation::class, 'encounterId');
    }

    public function treatments()
    {
        return $this->hasOne(Treatment::class, 'encounterId');
    }
}
