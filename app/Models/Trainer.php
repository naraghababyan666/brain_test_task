<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $table = 'trainers';

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'phone',
        'user_id'
    ];

    protected $hidden = [
    ];

    public function users(){
        return $this->belongsTo(Users::class, 'id', 'user_id');
    }
    public function role() {
        return $this->belongsTo(Roles::class);
    }
}
