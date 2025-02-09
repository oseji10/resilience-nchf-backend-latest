<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Patient extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'patients';
    protected $primaryKey = 'patientId';
    protected $fillable = [
    'firstName', 
    'lastName', 
    'otherNames', 
    'religion', 
    'gender', 
    'bloodGroup', 
    'address', 
    'occupation', 
    'hospitalFileNumber', 
    'dateOfBirth', 
    'doctor', 
    'status', 
    'hmo', 
    'hmoNumber',
    'nin', 
    'chfId',
    'userId',
    'cancer',
    'doctor',
    'dateOfBirth',
    'nextOfKinName',
    'nextOfKinAddress',
    'nextOfKinPhoneNumber',
    'nextOfKinRelationship',
    'nextOfKinEmail',
    'nextOfKinOccupation',
    'nextOfKinGender',
    'hospital',
    'stateOfOrigin',
    'stateOfResidence',
    'doctorId'
];
    protected $dates = ['deleted_at'];


    public function doctor()
    {
        return $this->belongsTo(Doctors::class, 'doctor', 'doctorId'); 
    }

    public function hmo()
    {
        return $this->belongsTo(HMOs::class, 'hmo', 'hmoId'); 
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital', 'hospitalId'); 
    }


    public function stateOfOrigin()
    {
        return $this->belongsTo(State::class, 'stateOfOrigin', 'stateId'); 
    }

    public function cancer()
    {
        return $this->belongsTo(Cancer::class, 'cancer', 'cancerId'); 
    }

    public function user(){
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function status(){
        return $this->hasOne(ApplicationReview::class, 'patientUserId', 'userId');
    }

}
