<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;
    public $table = 'geopolitical_zones';
    
    protected $primaryKey = 'zoneId';
    protected $fillable = [
      'zoneId',
      'zoneName',
    ];
    
    

}
