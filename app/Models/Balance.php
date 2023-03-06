<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_project_id',
        'starting_balance',
        'excepted_balance',
        'current_balance',
        'actual_balance',
        'balance_code',
    ];
}
