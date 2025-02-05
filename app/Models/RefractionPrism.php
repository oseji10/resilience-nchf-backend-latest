<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefractionPrism extends Model
{
    use HasFactory;
    public $table = 'refraction_prism';
    protected $fillable = ['name', 'status'];
}
