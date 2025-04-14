<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectedPatients extends Model
{
    use HasFactory;
    public $table = 'rejected_patients';
    protected $primaryKey = 'rejectionId';
    protected $fillable = [
    // 'medicalHistoryId',
    'patientUserId',
    'hospitalId',
    'rejectedBy',
    'reason',
    ];

  
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'patientUserId', 'id');
    }
}
