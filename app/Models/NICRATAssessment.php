<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NICRATAssessment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'nicrat_assessment';

    protected $primaryKey = 'assessmentId';

    protected $fillable = [
        'patientUserId',
        'comments',
        'status',
        'reviewerId'
    ];
}
