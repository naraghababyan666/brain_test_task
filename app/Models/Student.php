<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'email ',
        'password',
        'first_name',
        'last_name',
        'phone',
    ];

    protected $hidden = [
        'password',
    ];


    public function role() {
        return $this->belongsTo(Roles::class);
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }
    public function getJWTCustomClaims() {
        return [];
    }
}
