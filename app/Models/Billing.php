<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;
    public $table = 'billings';
    protected $fillable = [
    'transactionId',
    'patientId',
    'billingId', 
    'billingType',
    'categoryType',
    'billingName',
    'inventoryId',
    'productId',
    'serviceId',
    'cost',
    'quantity',
    'paymentMethod',
    'paymentStatus',
    'paymentReference',
    'paymentDate',
    'status',
    'comments',
    'billedBy',
    ];

    
    protected $primaryKey = 'billingId';

    public function billingUploads()
    {
        return $this->belongsTo(DocumentUpload::class, 'uploadedBy', 'documentId');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventoryId', 'inventoryId');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId', 'productId');
    }

    public function patient()
    {
        return $this->belongsTo(Patients::class, 'patientId', 'patientId');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'serviceId', 'serviceId');
    }
}
