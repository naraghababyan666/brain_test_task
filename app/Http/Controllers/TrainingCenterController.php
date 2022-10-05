<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use App\Models\Student;
use App\Models\Trainer;
use App\Models\TrainingCenter;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Fluent\Concerns\Has;

class TrainingCenterController extends Controller
{
    /**
     * *@OA\SecurityScheme(
     *     type="http",
     *     description="Login with email and password to get the authentication token",
     *     name="Token based Based",
     *     in="header",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     securityScheme="apiAuth",
     * )
     * @OA\Post(
     * path="/api/register/training-center",
     * description="Sign up as Training center",
     * operationId="trainingCenterRegister",
     * tags={"Sign up"},
     * @OA\RequestBody(
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password", "first_name", "last_name", "phone"},
     *       @OA\Property(property="email", type="string", format="email", example="center123@mail.ru"),
     *       @OA\Property(property="password", type="string", format="password", example="center"),
     *       @OA\Property(property="first_name", type="string", format="text", example="First name"),
     *       @OA\Property(property="last_name", type="string", format="text", example="Last name"),
     *       @OA\Property(property="phone", type="number", example="+374 98-066-083"),
     *       @OA\Property(property="tax_identity_number", type="string", example="777777"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
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
            'role' => UserRoles::TRAINING_CENTER
        ]);

        $data = $validator->validated();
        $data['user_id'] = $user->id;
        TrainingCenter::create($data);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * @OA\Post(
     * path="/api/create/trainer",
     * description="Sign up as trainer",
     * operationId="TrainingCenterCreateTrainer",
     * tags={"Training center actions"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password", "first_name", "last_name", "phone"},
     *       @OA\Property(property="email", type="string", format="email", example="trainer123@mail.ru"),
     *       @OA\Property(property="password", type="string", format="password", example="trainer"),
     *       @OA\Property(property="first_name", type="string", format="text", example="First name"),
     *       @OA\Property(property="last_name", type="string", format="text", example="Last name"),
     *       @OA\Property(property="phone", type="number", example="+374 98-066-083"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )

     */

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
            'role' => UserRoles::TRAINER
        ]);
        $validated['user_id'] = $user->id;
        $trainer = Trainer::create($validated);
        return response()->json([
            'message' => 'Trainer successfully registered',
            'trainer' => $trainer
        ], 201);
    }

    /**
     * @OA\Delete(
     * path="/api/delete/trainer/{id}",
     * description="Delete trainer",
     * operationId="Delete trainer",
     * tags={"Training center actions"},
     * security={{ "apiAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         name="id",
     *         description="Id trainer",
     *         required=true,
     *      ),
     * @OA\Response(
     *    response=204,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Empty list")
     *        )
     *     )
     * )

     */

    public function deleteTrainer($id){
        $user = Users::where('id', $id)->with('trainer')->delete();
         return response()->json(['success' => 'Successfully deleted!']);

    }

    /**
     * @OA\Post(
     * path="/api/update/trainer/{id}",
     * description="Update trainer",
     * operationId="Update trainer",
     * tags={"Training center actions"},
     * security={{ "apiAuth": {} }},
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     name="id",
     *     description="Id trainer",
     *     required=true,
     *  ),
     *@OA\RequestBody(
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       @OA\Property(property="email", type="string", format="email", example="trainer123@mail.ru"),
     *       @OA\Property(property="password", type="string", format="password", example="trainer"),
     *       @OA\Property(property="first_name", type="string", format="text", example="First name"),
     *       @OA\Property(property="last_name", type="string", format="text", example="Last name"),
     *       @OA\Property(property="phone", type="number", example="+374 98-066-083"),
     *    ),
     * ),
     * @OA\Response(
     *    response=204,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Empty list")
     *        )
     *     )
     * )

     */

    public function updateTrainer(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:2',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string'
        ]);
        $user = Users::where('id', $id)->with('trainer')->first();
        $user->email = $validator->validated()['email'];
        $user->password = Hash::make($validator->validated()['password']);
        $user->save();
        $newTrainer = [
            'email' => $validator->validated()['email'],
            'first_name' => $validator->validated()['first_name'],
            'last_name' => $validator->validated()['last_name'],
            'phone' => $validator->validated()['phone'],
        ];
        Trainer::where('user_id', $id)->update($newTrainer);
        return response()->json(['success' => 'Successfully updated'], 200);
    }

    /**
     * @OA\Post(
     * path="/api/trainers/list",
     * description="Sign up as trainer",
     * operationId="Trainers list",
     * tags={"Training center actions"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(
     *    response=204,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Empty list")
     *        )
     *     )
     * )

     */

    public function listTrainers(){
        $users = Users::with( 'trainer')->get();
        $trainers = [];
//        dd($users[1]->trainer);
        foreach ($users as $user){
            if($user->trainer){
                $trainers[] = $user;
            }
        }
        if($trainers !== []){
            return response()->json(['trainers' => $trainers]);
        }
        return response()->json(['fail' => 'Trainers not found!']);
    }

    /**
     * @OA\Post(
     * path="/api/trainer/{id}",
     * description="Sign up as trainer",
     * operationId="Current trainer",
     * tags={"Training center actions"},
     * security={{ "apiAuth": {} }},
        *     @OA\Parameter(
        *         name="id",
        *         in="path",
        *         name="id",
        *         description="Id trainer",
        *         required=true,
        *      ),
     * @OA\Response(
     *    response=204,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Empty list")
     *        )
     *     )
     * )

     */

    public function currentTrainer($id){
        $trainer = Trainer::where('user_id', $id)->first();
        if($trainer !== null){
            return response()->json(['trainer' => $trainer]);
        }
        return response()->json(['fail' => 'Trainer not found!']);
    }

}
