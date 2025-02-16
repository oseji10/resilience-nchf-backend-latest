<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $table = 'products';
    protected $fillable = [
    'productId',
    'productName',
    'productDescription',
    'productType',
    'productCategory',
    'productQuantity',
    'productCost',
    'productPrice',
    'productStatus',
    'productImage',
    'productManufacturer',
    'uploadedBy'

    ];

   protected $primaryKey = 'productId';

    public function productUploads()
    {
        return $this->belongsTo(DocumentUpload::class, 'uploadedBy', 'documentId');
    }

    public function stock(){
        return $this->belongsTo(Inventory::class, 'productId');
    }
}
