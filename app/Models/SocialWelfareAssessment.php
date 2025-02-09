<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialWelfareAssessment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'social_welfare_assessment';

    protected $primaryKey = 'assessmentId';

    protected $fillable = [
        'patientUserId',
        'appearance',
        'bmi',
        'commentOnHome',
        'commentOnEnvironment',
        'commentOnFamily',
        'generalComment',
        'status',
        'reviewerId'
    ];
}
