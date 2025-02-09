<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DoctorAssessment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'doctor_assessment';

    protected $primaryKey = 'assessmentId';

    protected $fillable = [
        'patientUserId',
        'carePlan',
        'amountRecommended',
        'status',
        'reviewerId'
    ];
}
