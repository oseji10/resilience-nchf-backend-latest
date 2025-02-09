<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialCondition extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'patient_social_condition';

    protected $primaryKey = 'socialConditionId';

    protected $fillable = [
        'patientUserId',
        'runningWater',
        'toiletType',
        'powerSupply',
        'meansOfTransport',
        'mobilePhone',
        'howPhoneIsRecharged',
        'status',
        'reviewerId'
    ];

}
