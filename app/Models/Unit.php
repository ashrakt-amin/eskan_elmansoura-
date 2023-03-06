<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Construction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'property_id',
        'sub_property_id',
        'main_project_id',
        'construction_id',
        'level_id',
        'site_id',
        'space',
        'price_m',
        'unit_price',
        'unitDescription',
        'status',
        'customer_id',
        'installments_count',
        'discount',
        'finance_id',
    ];

    public function property() {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }

    public function subProperty() {
        return $this->belongsTo(SubProperty::class);
    }

    public function mainProject() {
        return $this->belongsTo(MainProject::class, 'main_project_id', 'id');
    }

    public function construction() {
        return $this->belongsTo(Construction::class, 'construction_id', 'id');
    }

    public function customers() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id')->withDefault(
            ['name'=> 'لا يوجد عميل']
        );
    }

    public function level() {
        return $this->belongsTo(Level::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class, 'unit_id', 'id');
    }

    public function overMuchUnits() {
        return $this->hasMany(OverMuchUnit::class);
    }

    public function financePercentages() {
        return $this->hasMany(FinancePercentage::class);
    }

    public function installments() {
        return $this->hasMany(Installment::class, 'unit_id', 'id');
    }

    public function unitStatusDates()
    {
        return $this->belongsToMany(UnitStatusDate::class);
    }

    public function finance() {
        return $this->belongsTo(Finance::class, 'finance_id', 'id');
    }

    public function site() {
        return $this->belongsTo(Site::class);
    }

    public function commission() {
        return $this->hasOne(Commission::class);
    }
}
