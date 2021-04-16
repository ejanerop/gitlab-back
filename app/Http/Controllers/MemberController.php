<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

class MemberController extends Controller
{
    public function index( Request $request )
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => env('GITLAB_API_URL'),
            'timeout'  => 5.0,
            ]
        );
        try {
            $response = $client->get("users?per_page=80" , ['headers' => [
                'PRIVATE-TOKEN' => $user->gitlab_token
                ]]
            );
        } catch (ClientException $e) {
            return response()->json('Error', $e->getResponse()->getStatusCode());
        } catch (ConnectException $e) {
            return response()->json('Tiempo de espera agotado.', 408);
        }
        return response()->json(json_decode($response->getBody()), 200);

    }

    public function show( Request $request , $member )
    {
        $auth_user = $request->user();
        $client = new Client([
            'base_uri' => env('GITLAB_API_URL'),
            'timeout'  => 5.0,
            ]
        );
        try {
            $response = $client->get("users/" . $member , ['headers' => [
                'PRIVATE-TOKEN' => $auth_user->gitlab_token
                ]]
            );
        } catch (ClientException $e) {
            return response()->json('Error', $e->getResponse()->getStatusCode());
        } catch (ConnectException $e) {
            return response()->json('Tiempo de espera agotado.', 408);
        }
        return response()->json(json_decode($response->getBody()), 200);
    }

    public function memberships( Request $request, $member )
    {
        $auth_user = $request->user();
        $client = new Client([
            'base_uri' => env('GITLAB_API_URL'),
            'timeout'  => 5.0,
            ]
        );
        try {
            $response = $client->get("users/" . $member . "/memberships", ['headers' => [
                'PRIVATE-TOKEN' => $auth_user->gitlab_token
                ]]
            );
        } catch (ClientException $e) {
            return response()->json('Error', $e->getResponse()->getStatusCode());
        } catch (ConnectException $e) {
            return response()->json('Tiempo de espera agotado.', 408);
        }
        return response()->json(json_decode($response->getBody()), 200);
    }

}
