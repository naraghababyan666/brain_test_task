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
        return $this->hasOne(Users::class, 'id', 'user_id');
    }

    public function role() {
        return $this->hasMany(Roles::class, 'id', 'role_id');
    }


}
