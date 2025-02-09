<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MDTAssessment extends Model
{
    protected $table = 'mdt_assessment';

    protected $primaryKey = 'assessmentId';

    protected $fillable = [
        'patientUserId',
        'diagnosticProceedures',
        'costAssociatedWithSurgery',
        'servicesToBereceived',
        'medications',
        'radiotherapyCost',
        'status',
        'reviewerId'
    ];
}
