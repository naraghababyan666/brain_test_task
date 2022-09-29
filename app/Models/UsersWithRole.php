<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersWithRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    public function users(){
        return $this->hasMany(Users::class);
    }

    public function role() {
        return $this->belongsTo(Roles::class);
    }


}
