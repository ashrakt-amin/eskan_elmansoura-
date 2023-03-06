<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Installment extends Model
{
    use HasFactory;


    protected $fillable = [
        'unit_id',
        'customer_id',
        'installment_value',
        'installment_month',
        'installment_recovery',
        'residual_installments',
        'cancellation_code',
    ];


    public function property() {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }

    public function mainProject() {
        return $this->belongsTo(MainProject::class, 'main_project_id', 'id');
    }

    public function construction() {
        return $this->belongsTo(Construction::class, 'construction_id', 'id');
    }

    public function finance() {
        return $this->belongsT(Finance::class);
    }

    public function unit() {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function residual() {
        return $this->hasOne(Residual::class, 'installment_id' ,'id');
    }
}
