<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Trainer;
use App\Models\Users;
use App\Models\UsersWithRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TrainerController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100|unique:trainers',
            'password' => 'required|string|min:2',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = Trainer::create([
            'email' => $validator->validated()['email'],
            'password' => Hash::make($validator->validated()['password']),
            'first_name' => $validator->validated()['first_name'],
            'last_name' => $validator->validated()['last_name'],
            'phone' => $validator->validated()['phone'],
        ]);

        $allUsersTable = Users::create([
            'email' => $validator->validated()['email'],
            'password' => Hash::make($validator->validated()['password']),
            'table' => 'trainer'
        ]);
        UsersWithRole::create([
            'user_id' => $allUsersTable->id,
            'role_id' => 2
        ]);
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


}
