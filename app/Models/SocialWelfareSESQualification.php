<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialWelfareSESQualification extends Model
{
    use HasFactory;

    protected $table = 'social_welfare_ses_qualification';
    protected $primaryKey = 'qualificationId';

    

    protected $fillable = [
        'qualificationName',
    ];
}
