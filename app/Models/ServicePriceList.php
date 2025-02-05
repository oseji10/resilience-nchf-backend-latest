<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePriceList extends Model
{
    use HasFactory;
    public $table = 'service_price_list';
    protected $fillable = [
    'serviceId',
    'price',
    'discount',
    'discountType',
    'status',
    'createdBy',
    'updatedBy'

    ];

  
}
