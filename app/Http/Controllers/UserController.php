<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request )
    {
        $validate = $request->validate([
            'name'     => 'required|string|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'token'    => 'required|string'
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('name'));
        $user->gitlab_token = $request->input('token');
        $user->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show( User $user )
    {
        return $user->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validate = $request->validate([
            'name'  => ['required', 'string', Rule::unique('users')->ignore($user)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user)],
            'token' => 'required|string'
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->gitlab_token = $request->input('token');
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request, User $user )
    {
        if ($request->user()->id == $user->id) {
            return response()->json('No se puede eliminar el usuario autenticado', 403);
        }
        $user->delete();
        return response()->json('Eliminado correctamente', 204);
    }
}
