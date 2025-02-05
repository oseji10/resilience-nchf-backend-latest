<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisualAcuityNear extends Model
{
    use HasFactory;
    public $table = 'visual_acuity_near';
    protected $fillable = ['name', 'status'];
}
