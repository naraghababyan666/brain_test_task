<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainingCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('training_centers')->insert([
            'email' => 'center@admin.com',
            'password' => '$2y$10$KqAPwrbscLO.UXaCMetz1ejboyEC1MGG6oJOGrhlluLnmp6uUJi/y',
            'first_name' => 'Center',
            'last_name' => 'Director',
            'phone' => '+374 98-066-083',
            'tax_identity_number' => 'abc777',
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);
    }
}
