<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalStaff extends Model
{
    use HasFactory;
    public $table = 'hospital_staff';
    
    protected $primaryKey = 'hospitalStaffId';
    protected $fillable = [
       'hospitalStaffId',
       'userId',
       'hospitalId'
    ];

    

    public function user()
    {
        return $this->belongsTo(Users::class, 'userId');
    }

    public function hospitalAdmin()
    {
        return $this->hasOne(User::class, 'id', 'hospitalAdmin');
    }

    public function hospitalCMD()
    {
        return $this->hasOne(User::class, 'id', 'hospitalCMD');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospitalId');
    }
}
