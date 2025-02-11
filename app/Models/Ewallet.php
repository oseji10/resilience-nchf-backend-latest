<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ewallet extends Model
{
    use HasFactory;
    public $table = 'e_wallet';
    protected $fillable = ['walletId', 'hospitalId', 'comments'];
    protected $primaryKey = 'walletId';

   
}
