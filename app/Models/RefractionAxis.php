<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefractionAxis extends Model
{
    use HasFactory;
    public $table = 'refraction_axis';
    protected $fillable = ['name', 'status'];
}
