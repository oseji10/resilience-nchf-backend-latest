<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulting extends Model
{
    use HasFactory;
    public $table = 'consulting';
    protected $fillable = [
        'patientId',
        'encounterId',
        'visualAcuityFarPresentingLeft',
        'visualAcuityFarPresentingRight',
        'visualAcuityFarPinholeRight',
        'visualAcuityFarPinholeLeft',
        'visualAcuityFarBestCorrectedLeft',
        'visualAcuityFarBestCorrectedRight',
        'visualAcuityNearLeft',
        'visualAcuityNearRight'
    ];
    protected $primaryKey = 'consultingId';
    public function encounters()
    {
        return $this->belongsTo(Encounters::class, 'encounterId', 'encounterId');
    }

    public function patients()
    {
        return $this->hasMany(Patients::class, 'patientId', 'patientId');
    }

 // Relationship with VisualAcuityFar
 public function visualAcuityFarPresentingRight()
 {
     return $this->belongsTo(VisualAcuityFar::class, 'visualAcuityFarPresentingRight');
 }

 public function visualAcuityFarPresentingLeft()
 {
     return $this->belongsTo(VisualAcuityFar::class, 'visualAcuityFarPresentingLeft');
 }

 public function visualAcuityFarPinholeRight()
 {
     return $this->belongsTo(VisualAcuityFar::class, 'visualAcuityFarPinholeRight');
 }

 public function visualAcuityFarPinholeLeft()
 {
     return $this->belongsTo(VisualAcuityFar::class, 'visualAcuityFarPinholeLeft');
 }

 public function visualAcuityFarBestCorrectedRight()
 {
     return $this->belongsTo(VisualAcuityFar::class, 'visualAcuityFarBestCorrectedRight');
 }

 public function visualAcuityFarBestCorrectedLeft()
 {
     return $this->belongsTo(VisualAcuityFar::class, 'visualAcuityFarBestCorrectedLeft');
 }

 public function visualAcuityNearRight()
 {
     return $this->belongsTo(VisualAcuityNear::class, 'visualAcuityNearRight');
 }

 public function visualAcuityNearLeft()
 {
     return $this->belongsTo(VisualAcuityNear::class, 'visualAcuityNearLeft');
 }
}
