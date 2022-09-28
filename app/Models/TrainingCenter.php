<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCenter extends Model
{
    use HasFactory;

    protected $table = 'training_centers';

    public function role() {
        return $this->belongsTo(Roles::class);
    }
}
