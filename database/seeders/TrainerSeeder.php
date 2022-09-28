<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('trainers')->insert([
            'email' => 'trainerr@admin.com',
            'password' => '$2y$10$KqAPwrbscLO.UXaCMetz1ejboyEC1MGG6oJOGrhlluLnmp6uUJi/y',
            'first_name' => 'Center',
            'last_name' => 'Trainer',
            'phone' => '+374 98-066-083',
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);
    }
}
