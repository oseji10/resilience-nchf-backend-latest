<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HMOs extends Model
{
    use HasFactory;
    public $table = 'hmos';
    protected $fillable = ['hmoId', 'hmoName'];
    protected $primaryKey = 'hmoId';

   
}
