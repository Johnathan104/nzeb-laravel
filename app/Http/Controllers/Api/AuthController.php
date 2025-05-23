<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
class AuthController extends Controller
{
    public function getUser($id){
        $user = User::find($id);
        if(!$user){
            return response('User not found', 404);
        }else{
            return response ($user, 200);
        }
    }
    //
    public function login (LoginRequest $request)
    {
       $credentials  =$request->validated();
       if (!Auth::attempt($credentials)){
        return response ([
            'message'=>'provided email or password is incorrect',
            ''
        ]);
       }
       $user = Auth::user();
       $token = $user->createToken('main')->plainTextToken;
       return response(compact('user', 'token'));
    }
    public function signup(SignupRequest $request)
    {
        $data = $request->validated();
        /** @var \App\Models\User $user */
        $user = User::create([
            "name"=> $data["name"],
            'email'=> $data['email'],
            'password'=> bcrypt($data['password']),

        ]);
        $token = $user->createToken('main')->plainTextToken;
        return response ([
            'user'=>$user,
            'token'=>$token
        ]);
    }
    public function getSelf(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        return response(compact('user'));
    }
    public function logout(Request $request){
        /** @var User $user */
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response('', 204);
    }
}
