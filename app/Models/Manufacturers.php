<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturers extends Model
{
    use HasFactory;
    public $table = 'manufacturers';
    protected $fillable = ['manufacturerName'];

    // public function patients()
    // {
    //     return $this->hasMany(Patients::class, 'doctor', 'doctorId');
    // }
}
