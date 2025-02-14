<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NicratPool extends Model
{
    use HasFactory;
    protected $table = 'pool';

    protected $primaryKey = 'walletId';

    protected $fillable = [
        'balance',
        'comments',
        'lastUpdatedBy',
        'createdBy'
    ];
}
