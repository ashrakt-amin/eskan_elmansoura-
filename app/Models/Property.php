<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',

    ];

    public function subProperties()
    {
        return $this->belongsToMany(SubProperty::class);
    }


    public function customers()
    {
        return $this->belongsToMany(customer::class);
    }

    public function mainProjects() {
        return $this->hasMany(MainProject::class, 'property_id', 'id');
    }

    public function units() {
        return $this->hasMany(Unit::class, 'property_id', 'id');
    }

    public function installments() {
        return $this->hasMany(Installment::class, 'property_id', 'id');
    }

    public function constructions() {
        return $this->hasMany(Construction::class);
    }

}
