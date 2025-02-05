<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refraction extends Model
{
    use HasFactory;
    public $table = 'refractions';
    protected $fillable = [
        'patientId', 			
        'encounterId',
        'nearAddRight',
        'nearAddLeft',
        'OCTRight',
        'OCTLeft',
        'FFARight',
        'FFALeft',
        'fundusPhotographyRight',
        'fundusPhotographyLeft',
        'pachymetryRight',
        'pachymetryLeft',
        'CUFTRight',
        'CUFTLeft',
        'CUFTKineticRight',
        'CUFTKineticLeft',
        'pupilRight',
        'pupilLeft',
        'refractionSphereRight',
        'refractionSphereLeft',
        'refractionCylinderRight',
        'refractionCylinderLeft',
        'refractionAxisRight',
        'refractionAxisLeft',
        'refractionPrismRight',
        'refractionPrismLeft',
    ];
    protected $primaryKey = 'refractionId';
    public function encounters()
    {
        return $this->belongsTo(Encounters::class, 'encounterId', 'encounterId');
    }

    public function patients()
    {
        return $this->hasMany(Patients::class, 'patientId', 'patientId');
    }

    public function sphereRight()
    {
        return $this->belongsTo(RefractionSphere::class, 'refractionSphereRight');
    }

    public function sphereLeft()
    {
        return $this->belongsTo(RefractionSphere::class, 'refractionSphereLeft');
    }

    public function cylinderRight()
    {
        return $this->belongsTo(RefractionCylinder::class, 'refractionCylinderRight');
    }

    public function cylinderLeft()
    {
        return $this->belongsTo(RefractionCylinder::class, 'refractionCylinderLeft');
    }

    public function axisRight()
    {
        return $this->belongsTo(RefractionAxis::class, 'refractionAxisRight');
    }

    public function axisLeft()
    {
        return $this->belongsTo(RefractionAxis::class, 'refractionAxisLeft');
    }

    public function prismRight()
    {
        return $this->belongsTo(RefractionPrism::class, 'refractionPrismRight');
    }

    public function prismLeft()
    {
        return $this->belongsTo(RefractionPrism::class, 'refractionPrismLeft');
    }
}
