<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    public $table = 'services';
    protected $fillable = [
    'serviceId',
    'serviceName',
    'serviceDescription',
    'serviceType',
    'serviceCategory',
    'serviceCost',
    'servicePrice',
    'serviceStatus',
    'uploadedBy'


    ];

   protected $primaryKey = 'serviceId';

    public function productUploads()
    {
        return $this->belongsTo(DocumentUpload::class, 'uploadedBy', 'documentId');
    }
}
