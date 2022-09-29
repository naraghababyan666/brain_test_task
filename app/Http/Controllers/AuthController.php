<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login (Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            $user = Users::where('email', $request->email)->first();
            if($user){
                if(!Hash::check($user->password, $validator->validated()['password'])){
                    return response()->json('Invalid password', 201);
                }
            } else {
                return response()->json('Invalid email', 201);
            }
        }
        return $this->createNewToken($token);
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
//            'user' => auth()->user()->load(['role'])
            'user' => auth()->user()
        ]);
    }
}
