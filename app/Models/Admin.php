<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'gender',
        'phone',
        'email',
        'password',
        'privilege_id',
    ];
       
    public function privilege() {
        return $this->belongsTo(Privilege::class, 'privilege_id', 'id');
    }
}
