<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;
    public $table = 'clusters';
    
    protected $primaryKey = 'clusterId';
    protected $fillable = [
      'subhubId', 'clusterId',	'hospitalId',	'clusterName',	'clusterCode',	'clusterType',	'status',	'stateId'
    ];
    
    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospitalId');
    }
}
