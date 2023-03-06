<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];


    public function customers() {
        return $this->hasMany(Customer::class, 'privilege_id', 'id');
    }

    public function users() {
        return $this->hasMany(User::class, 'privilege_id', 'code');
    }

    public function admins() {
        return $this->hasMany(Admin::class, 'privilege_id', 'id');
    }

}
