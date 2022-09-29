<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function student() {
        return $this->hasMany(Student::class);
    }

    public function trainer() {
        return $this->hasMany(Trainer::class);
    }

    public function trainingcenter() {
        return $this->hasMany(TrainingCenter::class);
    }
//
//    public function users(){
//        return $this->hasMany(Users::class);
//    }
}
