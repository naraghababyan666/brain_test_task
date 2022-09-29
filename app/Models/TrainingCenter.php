<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class TrainingCenter extends Model implements JWTSubject
{
    use HasFactory;

    protected $table = 'training_centers';

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
        'tax_identity_number',
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
