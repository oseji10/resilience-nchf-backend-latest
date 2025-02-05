<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Patients extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'patients';
    protected $primaryKey = 'patientId';
    protected $fillable = ['firstName', 'lastName', 'otherNames', 'phoneNumber', 'email', 'gender', 'bloodGroup', 'address', 'occupation', 'hospitalFileNumber', 'dateOfBirth', 'doctor', 'status', 'hmoId'];
    protected $dates = ['deleted_at'];


    public function doctor()
    {
        return $this->belongsTo(Doctors::class, 'doctor', 'doctorId'); 
    }

    public function hmo()
    {
        return $this->belongsTo(HMOs::class, 'hmoId', 'hmoId'); 
    }

    public function encounters()
    {
        return $this->hasMany(Encounters::class, 'patientId', 'patientId'); 
    }

}
