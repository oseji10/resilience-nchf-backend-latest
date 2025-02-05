<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPriceList extends Model
{
    use HasFactory;
    public $table = 'product_price_list';
    protected $fillable = [
    'productId',
    'price',
    'discount',
    'discountType',
    'status',
    'createdBy',
    'updatedBy'


    ];

   public function productUploads()
    {
        return $this->belongsTo(DocumentUpload::class, 'uploadedBy', 'documentId');
    }
}
