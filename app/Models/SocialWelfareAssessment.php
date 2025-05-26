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
        'parent1Education',
        'parent2Education',
        'parent1Occupation',
        'parent2Occupation',
        'useSecondParent',
        'sesResult',
        'reviewerId'
    ];

    public function ses_occupation1(){
        return $this->belongsTo(SocialWelfareSESOccupation::class, 'parent1Occupation', 'occupationId');
    }

    public function ses_qualification1(){
        return $this->belongsTo(SocialWelfareSESQualification::class, 'parent1Education', 'qualificationId');
    }

    public function ses_occupation2(){
        return $this->belongsTo(SocialWelfareSESOccupation::class, 'parent2Occupation', 'occupationId');
    }

    public function ses_qualification2(){
        return $this->belongsTo(SocialWelfareSESQualification::class, 'parent2Education', 'qualificationId');
    }
}

