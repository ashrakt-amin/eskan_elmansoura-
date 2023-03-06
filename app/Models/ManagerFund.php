<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerFund extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'kind',
        'category',
        'value',
        'comment',
    ];
}
