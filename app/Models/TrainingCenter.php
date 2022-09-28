<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCenter extends Model
{
    use HasFactory;

    protected $table = 'training_centers';

    protected $fillable = [
        'email ',
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
}
