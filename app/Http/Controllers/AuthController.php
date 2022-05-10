<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    protected $user;

    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->user = new User();
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

        $user = $this->user->addNewUser($request);

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

        $user = $this->user->getUserFilteredByEmail($request);

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
            'expires_in' => auth()->factory()->getTTL()*60
        ]);
    }

    public function logout(){
        auth()->logout();

        return response()->json([
            'message' => 'User logged out',
        ]);
    }

}
