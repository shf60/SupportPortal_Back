<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;


class AuthController extends Controller
{
    public function register(Request $request){
        $fields=$request->validate([
            'name'=> 'required|string',
            'userName'=>'required|string|unique:users,userName',
            'password'=>'required|string|confirmed'
        ]);
        $user=User::create([
            'name'=>$fields['name'],
            'userName'=>$fields['userName'],
            'password'=> bcrypt($fields['password'])

        ]);
        $token=$user->createToken('token')->plainTextToken;

        $response=[
            'user'=>$user,
            'token'=>$token
        ];

        return response($response,201);
    }
    public function login(Request $request){
        $fields=$request->validate([
            'userName'=>'required|string',
            'password'=>'required|string'
        ]);
        //check email
        $user=User::where('userName',$fields['userName'])->first();
        
        //check password
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response(['message'=>'bad creds'],401);
        }
        $token=$user->createToken('token')->plainTextToken;

        $response=[
            'user'=>$user,
            'token'=>$token
        ];

        return response($response,201);
    }
    public function logout(Request $request){
        // return "hello";
        auth()->user()->tokens()->delete();

        return [
            'message'=>'Logged Out'
        ];
    }
}
