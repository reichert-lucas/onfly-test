<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\System;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if ($user = User::where('email', $request->email)->first()) {
            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'user' => new UserResource($user),
                    'token' => $user->createToken('token')->plainTextToken,
                ], 200);   
            }
        }

        return response()->json([
            'message' => 'Essas credenciais não foram encontradas em nossos registros.',
        ], 401);
    }

    public function me(Request $request)
    { 
        return response()->json(new UserResource($request->user()), 200);   
    }

    public function logout(Request $request)
    { 
        if ($request->user()->currentAccessToken()->delete()) {
            $response['message'] = 'Logout Efetuado com Sucesso.';
            return response()->json($response, 200);
        }

        $response['message'] = 'Algo deu Errado.';
        return response()->json($response, 500);
    }

    public function refresh(Request $request)
    { 
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'token' => $request->user()->createToken('api')->plainTextToken
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        /** @var $user App\Models\User **/
        $user = auth()->user();
        
        $user->update($request->validated());

        return response()->json(new UserResource($user));
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        /** @var $user App\Models\User **/
        $user = auth()->user();
        
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json();
    }

    public function chooseSystem(System $system)
    {
        /** @var $user App\Models\User **/
        $user = auth()->user();
        
        $user->system_id = $system->id;
        $user->save();

        return response()->json(new UserResource($user));
    }
}
