<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    use HasFactory;
    public $table = 'hubs';
    
    protected $primaryKey = 'hubId';
    protected $fillable = [
       'hubId',	'hospitalId',	'hubName',	'hubCode',	'hubType',	'status',	'stateId'
    ];

    public function subhubs()
    {
        return $this->hasMany(SubHub::class, 'hubId');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospitalId', 'hospitalId');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'stateId');
    }
}
