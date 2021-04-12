<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login( Request $request ) {
        $validate = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string'
            ]
        );
        $user = User::where('name', $request->input('name'))->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return ['user'=>$user , 'token' => $user->tokens()->first()->token];
        }
        return response()->json('Usuario y/o contraseña incorrecto', 401);
    }
}
