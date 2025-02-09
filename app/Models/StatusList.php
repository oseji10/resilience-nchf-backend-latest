<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusList extends Model
{
    use HasFactory;
    public $table = 'application_status_list';
    protected $primaryKey = 'statusId';
    protected $fillable = [
        'statusId',
        'label',
        'description',
        'status',
    ];
    
}
