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
use Illuminate\Testing\Fluent\Concerns\Has;

class TrainingCenterController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:2',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'tax_identity_number' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = Users::create([
            'email' => $validator->validated()['email'],
            'password' => Hash::make($validator->validated()['password']),
            'table' => 'training_center'
        ]);

        TrainingCenter::create([
            'email' => $validator->validated()['email'],
            'password' => Hash::make($validator->validated()['password']),
            'first_name' => $validator->validated()['first_name'],
            'last_name' => $validator->validated()['last_name'],
            'phone' => $validator->validated()['phone'],
            'tax_identity_number' => $validator->validated()['tax_identity_number'],
            'user_id' => $user->id
        ]);

        UsersWithRole::create([
            'user_id' => $user->id,
            'role_id' => 3
        ]);
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function createTrainer(Request $request){
        $validated = $request->validate([
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:2',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
        ]);
        $user = Users::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'table' => 'trainer'
        ]);

        $newTrainer = Trainer::create([
            'email' => $validated['email'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'user_id' => $user->id
        ]);

        UsersWithRole::create([
            'user_id' => $user->id,
            'role_id' => 2
        ]);
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $newTrainer
        ], 201);
    }

    public function deleteTrainer($id){
        $user = Users::where('id', $id)->with('trainer', 'userswithrole')->delete();
         return response()->json(['success' => 'Successfully deleted!']);

    }

    public function updateTrainer(Request $request, $id){
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:2',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
        ]);
        $user = Users::where('id', $id)->first();
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->table = 'trainer';
        $user->save();

        $trainer = Trainer::where('user_id', $id)->first();
        $trainer->first_name = $validated['first_name'];
        $trainer->last_name = $validated['last_name'];
        $trainer->phone = $validated['phone'];
        $trainer->email = $validated['email'];
        $trainer->save();

        return response()->json(['success' => 'Successfully updated'], 200);
    }

    public function listTrainers(){
        $users = Users::with( 'trainer')->get();
        $trainers = [];
        foreach ($users as $user){
            if($user['userswithrole']['role_id'] === 2){
                $trainers[] = $user;
            }
        }
        if($trainers !== []){
            return response()->json(['trainers' => $trainers]);
        }
        return response()->json(['fail' => 'Trainers not found!']);
    }

    public function currentTrainer($id){
        $trainer = Trainer::where('user_id', $id)->first();
        if($trainer !== null){
            return response()->json(['trainer' => $trainer]);
        }
        return response()->json(['fail' => 'Trainer not found!']);
    }

}
