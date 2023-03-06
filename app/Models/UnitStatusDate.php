<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitStatusDates extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    
    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }
    
    public function units()
    {
        return $this->belongsToMany(Unit::class);
    }

}
