<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'student',
        ]);
        DB::table('roles')->insert([
            'name' => 'trainer'
        ]);
        DB::table('roles')->insert([
            'name' => 'training_center'
        ]);
    }
}
