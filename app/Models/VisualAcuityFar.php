<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisualAcuityFar extends Model
{
    use HasFactory;
    public $table = 'visual_acuity_far';
    protected $fillable = ['name', 'status'];

    public function consulting()
    {
        return $this->hasMany(Consulting::class, 'visualAcuityFarPresentingRight');
    }
}
