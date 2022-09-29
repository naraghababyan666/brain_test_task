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
}
