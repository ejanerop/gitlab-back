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

        $response = $client->get("users?per_page=50" , ['headers' => [
            'PRIVATE-TOKEN' => $user->gitlab_token
            ]]
        );

        return response()->json(json_decode($response->getBody()), 200);

    }

    public function show( Request $request , $member )
    {
        $auth_user = $request->user();
        $client = new Client([
            'base_uri' => "https://gitlab.com/api/v4/",
            'timeout'  => 5.0,
            ]
        );

        $response = $client->get("users/" . $member , ['headers' => [
            'PRIVATE-TOKEN' => $auth_user->gitlab_token
            ]]
        );

        return response()->json(json_decode($response->getBody()), 200);
    }

    public function memberships( Request $request, $member )
    {
        $auth_user = $request->user();
        $client = new Client([
            'base_uri' => "https://gitlab.com/api/v4/",
            'timeout'  => 5.0,
            ]
        );

        $response = $client->get("users/".$member."/memberships", ['headers' => [
            'PRIVATE-TOKEN' => $auth_user->gitlab_token
            ]]
        );

        return response()->json(json_decode($response->getBody()), 200);
    }

}
