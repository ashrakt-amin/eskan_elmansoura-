<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Residual extends Model
{
    use HasFactory;


    protected $fillable = [
        'unit_id',
        'customer_id',
        'payment_id',
        'installment_id',
        'unit_price',
        'all_payments',
        'payment_recovery',
        'all_residuals',
        'cancellation_code',
    ];


    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function installment()
    {
        return $this->belongsTo(Installment::class, 'installment_id', 'id');
    }

}
