<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function _construct(){
        $this->middleware('auth:api',['except' => ['login', 'register']]);
    }

    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|email|unique:user',
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

    }
}
