<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubHub extends Model
{
    use HasFactory;
    public $table = 'subhubs';
    
    protected $primaryKey = 'subhubId';
    protected $fillable = [
      'subhubId', 'hubId',	'hospitalId',	'subhubName',	'subhubCode',	'subhubType',	'status',	'stateId'
    ];
    
    public function clusters()
    {
        return $this->hasMany(Cluster::class, 'subhubId');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospitalId');
    }
}
