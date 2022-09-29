<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Trainer;
use App\Models\TrainingCenter;
use App\Models\Users;
use App\Models\UsersWithRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TrainingCenterController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100|unique:training_center',
            'password' => 'required|string|min:2',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'tax_identity_number' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = TrainingCenter::create([
            'email' => $validator->validated()['email'],
            'password' => Hash::make($validator->validated()['password']),
            'first_name' => $validator->validated()['first_name'],
            'last_name' => $validator->validated()['last_name'],
            'phone' => $validator->validated()['phone'],
            'tax_identity_number' => $validator->validated()['tax_identity_number'],
        ]);

        $allUsersTable = Users::create([
            'email' => $validator->validated()['email'],
            'password' => Hash::make($validator->validated()['password']),
            'table' => 'training_center'
        ]);
        UsersWithRole::create([
            'user_id' => $allUsersTable->id,
            'role_id' => 3
        ]);
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function createTrainer(Request $request){
        $validated = $request->validate([
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:2',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
        ]);
        $newTrainer = Trainer::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
        ]);
        $allUsersTable = Users::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'table' => 'trainer'
        ]);
        UsersWithRole::create([
            'user_id' => $allUsersTable->id,
            'role_id' => 2
        ]);
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $newTrainer
        ], 201);
    }

}
