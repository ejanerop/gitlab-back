<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ProjectController extends Controller
{
    public function index( Request $request )
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => "https://gitlab.com/api/v4/",
            'timeout'  => 5.0,
            ]
        );

        $response = $client->get("projects" , ['headers' => [
            'PRIVATE-TOKEN' => $user->gitlab_token
            ]]
        );

        return response()->json(json_decode($response->getBody()), 201);

    }

    public function show( Request $request , $project )
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => "https://gitlab.com/api/v4/",
            'timeout'  => 5.0,
            ]
        );

        $response = $client->get("projects/" . $project , ['headers' => [
            'PRIVATE-TOKEN' => $user->gitlab_token
            ]]
        );

        return response()->json(json_decode($response->getBody()), $response->getStatusCode());
    }

    public function members( Request $request , $project )
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => "https://gitlab.com/api/v4/",
            'timeout'  => 5.0,
            ]
        );

        $response = $client->get("projects/" . $project . "/members", ['headers' => [
            'PRIVATE-TOKEN' => $user->gitlab_token
            ]]
        );

        return response()->json(json_decode($response->getBody()), $response->getStatusCode());
    }

    public function deleteMember( Request $request , $project , $member )
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => "https://gitlab.com/api/v4/",
            'timeout'  => 5.0,
            ]
        );

        $response = $client->delete("projects/".$project."/members"."/".$member, ['headers' => [
            'PRIVATE-TOKEN' => $user->gitlab_token
            ]]
        );

        return response()->json(json_decode($response->getBody()), $response->getStatusCode());
    }
}
