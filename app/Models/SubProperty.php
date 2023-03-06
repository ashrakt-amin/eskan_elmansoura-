<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubProperty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',

    ];

    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }

    public function units()
    {
        return $this->HasMany(Unit::class);
    }

}
