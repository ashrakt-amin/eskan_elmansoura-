<?php

namespace App\Models;

use App\Models\Installment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Finance extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'monthes_count',

    ];

    public function payments() {
        return $this->hasMany(Payment::class, 'finance_id', 'id');
    }

    public function units() {
        return $this->hasMany(Unit::class, 'finance_id', 'id');
    }

    public function customers() {
        return $this->belongsToMany(Customer::class);
    }

    public function financePercentages() {
        return $this->hasMany(FinancePercentage::class, 'finance_id', 'id');
    }

}
