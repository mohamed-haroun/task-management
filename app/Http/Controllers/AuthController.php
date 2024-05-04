<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if(!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = Auth::user();

        return $this->success(data:[
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken
        ], message:'Login Success', code: 200);
    }

    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());

        $user = User::create([
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'password' => Hash::make($request->post('password')),
        ]);

        Auth::login($user);

        return $this->success(data:[
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken
        ], message:'register Success', code: 200);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
        return $this->success(data:'', message:'Logout Success', code: 200);
    }
}
