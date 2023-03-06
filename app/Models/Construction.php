<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\Level;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Construction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'property_id',
        'main_project_id',
        'levels',
        'level_units',
        'total_units',
        'coast',
    ];


        /**
     * The users that belong to the role.
     */
    public function customers()
    {
        // return $this->belongsToMany(Customer::class, 'construction_customer', 'construction_id', 'customer_id', 'id', 'id');
        return $this->belongsToMany(Customer::class);
    }

    public function property() {
        return $this->belongsTo(Property::class, 'property_id');
    }

    
    public function mainProject() {
        return $this->belongsTo(MainProject::class, 'main_project_id', 'id');
    }

    public function levels() {
        return $this->belongsToMany(Level::class);
    }

    public function units() {
        return $this->hasMany(Unit::class, 'construction_id', 'id');

    }


    public function installments() {
        return $this->hasMany(Installment::class, 'construction_id', 'id');
    }



}
