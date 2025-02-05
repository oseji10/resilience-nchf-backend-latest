<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicines extends Model
{
    use HasFactory;
    public $table = 'medicines';
    protected $fillable = ['medicineName','formulation', 'quantity', 'manufacturer', 'status', 'type', 'price'];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturers::class, 'manufacturer', 'manufacturerId');
    }
}
