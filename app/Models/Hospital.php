<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;
    public $table = 'hospitals';
    
    protected $primaryKey = 'hospitalId';
    protected $fillable = [
       'hospitalName',
         'address',
            'phone',
            'email',
            'website',
            'stateId',
            'hospitalCode',
            'hospitalType',
            'hospitalAdmin',
            'hospitalCMD',
            'status',
            'hospitalShortName'
    ];

    public function hubs()
    {
        return $this->hasMany(Hub::class, 'hospitalId');
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class, 'hospitalId');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'stateId');
    }

    public function hospitalAdmin()
    {
        return $this->hasOne(User::class, 'id', 'hospitalAdmin');
    }

    public function hospitalCMD()
    {
        return $this->hasOne(User::class, 'id', 'hospitalCMD');
    }

    public function wallet_balance()
    {
        return $this->hasOne(Ewallet::class, 'hospitalId');
    }
}
