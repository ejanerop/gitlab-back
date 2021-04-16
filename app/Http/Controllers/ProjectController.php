<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

class ProjectController extends Controller
{
    public function index( Request $request )
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => env('GITLAB_API_URL'),
            'timeout'  => 10.0,
            ]
        );
        try {
            $response = $client->get("projects" , ['headers' => [
                'PRIVATE-TOKEN' => $user->gitlab_token
                ]]
            );
        } catch (ClientException $e) {
            return response()->json('Error', $e->getResponse()->getStatusCode());
        } catch (ConnectException $e) {
            return response()->json('Tiempo de espera agotado.', 408);
        }


        return response()->json(json_decode($response->getBody()), $response->getStatusCode());

    }

    public function show( Request $request , $project )
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => env('GITLAB_API_URL'),
            'timeout'  => 5.0,
            ]
        );
        try {
            $response = $client->get("projects/" . $project , ['headers' => [
                'PRIVATE-TOKEN' => $user->gitlab_token
                ]]
            );
        } catch (ClientException $e) {
            return response()->json('Error', $e->getResponse()->getStatusCode());
        } catch (ConnectException $e) {
            return response()->json('Tiempo de espera agotado.', 408);
        }


        return response()->json(json_decode($response->getBody()), $response->getStatusCode());
    }

    public function members( Request $request , $project )
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => env('GITLAB_API_URL'),
            'timeout'  => 5.0,
            ]
        );
        try {
            $response = $client->get("projects/" . $project . "/members", ['headers' => [
                'PRIVATE-TOKEN' => $user->gitlab_token
                ]]
            );
        } catch (ClientException $e) {
            return response()->json('Error', $e->getResponse()->getStatusCode());
        } catch (ConnectException $e) {
            return response()->json('Tiempo de espera agotado.', 408);
        }


        return response()->json(json_decode($response->getBody()), $response->getStatusCode());
    }

    public function member( Request $request , $project, $member )
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => env('GITLAB_API_URL'),
            'timeout'  => 5.0,
            ]
        );
        try {
            $response = $client->get("projects/" . $project . "/members" . "/" . $member, ['headers' => [
                'PRIVATE-TOKEN' => $user->gitlab_token
                ]]
            );
        } catch (ClientException $e) {
            return response()->json('Error', $e->getResponse()->getStatusCode());
        } catch (ConnectException $e) {
            return response()->json('Tiempo de espera agotado.', 408);
        }


        return response()->json(json_decode($response->getBody()), $response->getStatusCode());
    }

    public function deleteMember( Request $request , $project , $member )
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => env('GITLAB_API_URL'),
            'timeout'  => 5.0,
            ]
        );
        try {
            $response = $client->delete("projects/" . $project . "/members" . "/" . $member, ['headers' => [
                'PRIVATE-TOKEN' => $user->gitlab_token
                ]]
            );
        } catch (ClientException $e) {
            return response()->json('Operación no permitida', $e->getResponse()->getStatusCode());
        } catch (ConnectException $e) {
            return response()->json('Tiempo de espera agotado.', 408);
        }


        return response()->json(json_decode($response->getBody()), $response->getStatusCode());
    }
}
