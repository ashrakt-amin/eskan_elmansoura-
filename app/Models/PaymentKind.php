<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentKind extends Model
{
    use HasFactory;


    protected $fillable = [
            'name',
            'main_project_id',
            'code'
        ];


    public function payments() {
        return $this->hasMany(Payment::class, 'payment_kind_id', 'id');
    }

    public function customers() {
        return $this->belongsToMany(Customer::class, 'payment_kind_id', 'id');
    }

    public function mainProject() {
        return $this->belongsTo(MainProject::class);
    }

    public function financePercentages() {
        return $this->hasMany(FinancePercentage::class, 'payment_kind_id', 'id');
    }
}
