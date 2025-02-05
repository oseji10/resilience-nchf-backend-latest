<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    public $table = 'inventory';
    protected $fillable = [
    'productId',
    'inventoryId', 
    'inventoryName',
    'inventoryType',
    'batchNumber',
    'expiryDate',
    'quantityReceived',
    'quantitySold',
    'quantityDamaged',
    'quantityReturned',
    'quantityExpired',
    
    'uploadedBy'

    
    ];
    protected $primaryKey = 'inventoryId';

    public function inventoryUploads()
    {
        return $this->belongsTo(DocumentUpload::class, 'uploadedBy', 'documentId');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId', 'productId');
    }
}
