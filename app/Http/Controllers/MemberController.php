<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MemberController extends Controller
{
    public function index( Request $request )
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => "https://gitlab.com/api/v4/",
            'timeout'  => 5.0,
            ]
        );

        $response = $client->get("users" , ['headers' => [
            'PRIVATE-TOKEN' => $user->gitlab_token
            ]]
        );

        return response()->json(json_decode($response->getBody()), 201);

    }

    public function show( Request $request , $user )
    {
        $auth_user = $request->user();
        $client = new Client([
            'base_uri' => "https://gitlab.com/api/v4/",
            'timeout'  => 5.0,
            ]
        );

        $response = $client->get("users/" . $user , ['headers' => [
            'PRIVATE-TOKEN' => $auth_user->gitlab_token
            ]]
        );

        return response()->json(json_decode($response->getBody()), 201);
    }
}
