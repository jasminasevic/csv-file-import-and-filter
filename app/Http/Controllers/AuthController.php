<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonException;
use App\Http\Requests\UserRequest;
use Validator;
use App\Models\User;
use App\Http\Requests\LoginUserRequest;

class AuthController extends Controller
{
    protected $user;

    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->user = new User();
    }

    public function register(UserRequest $request){

        $user = $this->user->addNewUser($request);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ],201);
    }

    public function login(LoginUserRequest $request){

        $user = $this->user->getUserFilteredByEmail($request);

        if(!$user){
            throw new GeneralJsonException('Unauthorized user', 401);
        }

        if (!password_verify($request->password, $user->password)) {
            throw new GeneralJsonException('Unauthorized user', 401);
        }

        if (! $token = auth()->login($user)) {
            throw new GeneralJsonException('Unauthorized user', 401);
        }

        return response([
            'api_token' => $this->createNewToken($token),
            'message' => 'User logged in successfully'
        ], 201);

    }

    public function createNewToken($token)
    {
        return response()->json([
           'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL()*60
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'User logged out',
        ]);
    }

}
