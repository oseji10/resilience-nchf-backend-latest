<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;
    public $table = 'appointments';
    protected $primaryKey = 'appointmentId';
    protected $fillable = ['appointmentId','patientId', 'encounterId', 'appointmentDate', 'appointmentTime', 'doctor', 'comment', 'createdBy'];

    public function patients()
    {
        return $this->belongsTo(Patients::class, 'patientId', 'patientId');
    }

    public function encounters()
    {
        return $this->belongsTo(Encounters::class, 'encounterId', 'encounterId');
    }

    public function doctors()
    {
        return $this->belongsTo(Doctors::class, 'doctor', 'doctorId');
    }
}
