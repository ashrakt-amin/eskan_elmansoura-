<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_kind_id',
        'payment_value',
        'payment_recovery',
        'customer_id',
        'unit_id',
        'cancellation_code',
        ];

        public function finance() {
            return $this->belongsTo(Finance::class, 'finance_id', 'id');
        }

        public function customer() {
            return $this->belongsTo(Customer::class, 'customer_id', 'id');
        }

        public function unit() {
            return $this->belongsTo(Unit::class, 'unit_id', 'id');
        }

        public function paymentKind() {
            return $this->belongsTo(PaymentKind::class, 'payment_kind_id', 'id');
        }

        public function residual() {
            return $this->hasOne(Residual::class);
        }

}
