<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancePercentage extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'payment_kind_id',
        'payment_kind_percentage',
        'payment_kind_value',
        'due_date',
    ];

    public function finance() {
        return $this->belongsTo(Finance::class, 'finance_id', 'id');
    }

    public function paymentKind() {
        return $this->belongsTo(PaymentKind::class, 'payment_kind_id', 'id');
    }

    public function unit() {
        return $this->belongsTo(Unit::class);
    }


}
