<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctors extends Model
{
    use HasFactory;
    public $table = 'doctors';
    protected $fillable = ['doctorName','title', 'department', 'status', 'userId'];

    public function patients()
    {
        return $this->hasMany(Patients::class, 'doctor', 'doctorId');
    }
}
