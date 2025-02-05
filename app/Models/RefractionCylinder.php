<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefractionCylinder extends Model
{
    use HasFactory;
    public $table = 'refraction_cylinder';
    protected $fillable = ['name', 'status'];
}
