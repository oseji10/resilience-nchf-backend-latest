<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EwalletTransaction extends Model
{
    use HasFactory;
    public $table = 'e_wallet_transactions';
    protected $fillable = ['transactionId', 'hospitalId', 'reason', 'walletId', 'amount', 'transactionType'];
    protected $primaryKey = 'transactionId';

   
}
