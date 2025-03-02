<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AUthenticationController extends Controller
{
    public function register(RegisterRequest $request){
        $request->validated();

        $userData = [
            'name' => $request-> name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];
        $user = User::create($userData);
        $token = $user->createToken('myapp')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(LoginRequest $request){
        $request->validated();

        $user = User::whereUsername($request->username)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response([
                'message'=> 'Invalid credentials'
            ], 422);
        }

        $token = $user->createToken('myapp')->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token
        ], 200);
    }
}
