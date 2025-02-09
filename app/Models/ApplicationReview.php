<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationReview extends Model
{
    use HasFactory;
    public $table = 'patient_application_review';
    protected $primaryKey = 'reviewId';
    protected $fillable = [
        'patientUserId',
        'reviewerId',
        'reviewerRole',
        'statusId',
        'comments',
    ];
    
    public function status_details(){
        return $this->belongsTo(StatusList::class, 'statusId');
    }
}
