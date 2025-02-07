<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    public $table = 'states';
    
    protected $primaryKey = 'stateId';
    protected $fillable = [
      'stateId',
      'zoneId',
      'stateName',
    ];
    
    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zoneId');
    }    

}
