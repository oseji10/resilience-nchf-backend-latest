<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;
    public $table = 'treatment';
    
    protected $primaryKey = 'treatmentId';
    protected $fillable = [
        'patientId',
        'encounterId',
        'treatmentType',
        'medicine',
        'dosage',
        'dosageDuration',
        'time',
        'doseInterval',
        'comment',
        'frame',
        'lensType',
        'costOfLens',
        'costOfFrame'
    ];
  
}
