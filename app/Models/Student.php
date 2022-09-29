<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Student extends Model implements JWTSubject
{
    use HasFactory, Notifiable, Authenticatable;

    protected $table = 'students';

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
    ];

    protected $hidden = [
        'password',
    ];

    protected $guarded = [];

    public function users(){
        return $this->belongsTo(Users::class);
    }

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
