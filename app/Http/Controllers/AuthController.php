<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }

        $user = User::create(array_merge(
            $validator -> validated(),
            ['password' => bcrypt($request->password)],
            ['role_id' => ($request->role_id)]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ],201);
    }

    public function login(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $user = User::where([
            'email' => $request->email,
        ])->first();

        if(!$user){
            return response()->json(['error' => 'Unauthorized user'], 401);
        }

        if (!password_verify($request->password, $user->password)) {
            return response()->json(['error' => 'Unauthorized user'], 401);
        }

        if (! $token = auth()->login($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    public function createNewToken($token){
        return response()->json([
           'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL()*60,
        //    'user' => auth()->user()
        ]);
    }

    public function logout(){
        auth()->logout();

        return response()->json([
            'message' => 'User logged out',
        ]);
    }

}
