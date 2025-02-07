<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientBiodata extends Model
{
    use HasFactory;
    public $table = 'patients';
    protected $fillable = [
        'patientId',
        'encounterId',
        'NIN',
        'userId',
        'chfId',
        'hospitalFileNumber',
        'hospital',
        'stateOfOrigin',
        'lgaOfOrigin',
        'stateOfResidence',
        'lgaOfResidence',
        'phoneNumber',
        'email',
        'gender',
        'bloodgroup',
        'occupation',
        'dateOfBirth',
        'address',
        'nextOfKin',
        'nextOfKinAddress',
        'nextOfKinPhoneNumber',
        'nextOfKinEmail',
        'nextOfKinRelationship',
        'nextOfKinOccupation',
        'nextOfKinGender',
        'hmoId',
        'cancerType',
        'doctor',
        'status',        
    ];
    protected $primaryKey = 'patientId';

   public function hospital(){
        return $this->belongsTo(Hospital::class, 'hospital', 'hospitalId');
    }

    public function stateOfOrigin(){
        return $this->belongsTo(State::class, 'stateOfOrigin', 'stateId');
    }

    public function lgaOfOrigin(){
        return $this->belongsTo(Lga::class, 'lgaOfOrigin', 'lgaId');
    }

    public function stateOfResidence(){
        return $this->belongsTo(State::class, 'stateOfResidence', 'stateId');
    }

    public function lgaOfResidence(){
        return $this->belongsTo(Lga::class, 'lgaOfResidence', 'lgaId');
    }

    public function hmo(){
        return $this->belongsTo(Hmo::class, 'hmoId', 'hmoId');
    }

    public function cancer(){
        return $this->belongsTo(Cancer::class, 'cancerType', 'cancerId');
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class, 'doctor', 'doctorId');
    }

    public function user(){
        return $this->belongsTo(User::class, 'userId', 'id');
    }

   
}
