<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;
    public $table = 'prescriptions';
    protected $fillable = [
    'prescriptionId',
    'patientId',
    'serviceId', 
    'productId',
    'comments',
    'type',
    'quantity',
    'prescribedBy',
    'hospitalId',
    ];

    public function item(){
        return $this->hasMany(PrescriptionItem::class, 'prescriptionId');
    }

    public function items(){
        return $this->hasMany(PrescriptionItem::class, 'prescriptionId');
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientId');
    }
}
