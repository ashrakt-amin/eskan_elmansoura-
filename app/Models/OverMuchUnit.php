<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverMuchUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_name',
        'unit_id',
        'price_m',
        'over_much',
        'new_price_m',
        'new_unit_price',
        'main_project_id',
    ];

    public function units() {
        return $this->belongsToMany(Unit::class);
    }

    public function mainProject() {
        return $this->belongsTo(MainProject::class);
    }
}
