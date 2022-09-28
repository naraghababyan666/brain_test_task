<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'table',
    ];

    public function userswithrole() {
        return $this->belongsTo(UsersWithRole::class);
    }
}
