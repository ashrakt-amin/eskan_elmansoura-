<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id',
        'unit_id',
        'percentage',
        'commission_value',
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function unit() {
        return $this->belongsTo(Unit::class);
    }

}
