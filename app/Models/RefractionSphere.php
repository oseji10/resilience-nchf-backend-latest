<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefractionSphere extends Model
{
    use HasFactory;
    public $table = 'refraction_sphere';
    protected $fillable = ['name', 'status'];
}
