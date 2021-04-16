<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login( Request $request )
    {
        $validate = $request->validate([
            'name'     => 'required|string',
            'password' => 'required|string'
            ]
        );
        $user = User::where('name', $request->input('name'))->first();

        if ( $user && Hash::check($request->password, $user->password) ) {
            $user->tokens()->delete();
            $token = $user->createToken('access');
            return ['user'=> $user , 'token' => $token->plainTextToken];
        }
        return response()->json('Usuario y/o contraseña incorrecto', 422);
    }

    public function logout( Request $request )
    {
        $user = $request->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return $user;
    }
}
