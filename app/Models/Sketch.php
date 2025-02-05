<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sketch extends Model
{
    use HasFactory;
    public $table = 'sketch';
    protected $fillable = ['sketchId','patientId', 'encounterId', 'right_eye_front', 'right_eye_back', 'left_eye_front', 'left_eye_back'];
    protected $primaryKey = 'sketchId';
  
}
