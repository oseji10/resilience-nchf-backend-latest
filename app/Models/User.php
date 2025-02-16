<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    use HasApiTokens, Notifiable;

    public $table = 'users';
    protected $fillable = [
        'phoneNumber',
        'email',
        'role',
        'firstName',
        'lastName',
        'otherNames',
        'password', 
        'languageId'
    ];
    protected $dates = ['deleted_at'];

    public function role()
    {
        return $this->hasOne(Roles::class, 'roleId', 'role'); // Assuming doctorId is the foreign key
    }

    public function hospital_admins()
    {
        return $this->belongsTo(HospitalStaff::class, 'id', 'userId'); 
    }


     
}
