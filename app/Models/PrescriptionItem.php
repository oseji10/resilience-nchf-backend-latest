<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    use HasFactory;
    public $table = 'prescription_items';
    protected $fillable = [
    'prescriptionId',
    'patientUserId',
    'serviceId', 
    'productId',
    'comments',
    'type',
    'quantity',
    'prescribedBy'
    
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'productId');
    }
    public function service(){
        return $this->belongsTo(Service::class, 'serviceId');
    }

    public function stock(){
        return $this->belongsTo(Inventory::class, 'productId');
    }
}
