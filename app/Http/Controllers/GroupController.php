<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

class GroupController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index( Request $request )
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => env('GITLAB_API_URL'),
            'timeout'  => 5.0,
            ]
        );
        try {
            $response = $client->get("groups?per_page=50" , ['headers' => [
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

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show( Request $request, $id)
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => env('GITLAB_API_URL'),
            'timeout'  => 5.0,
            ]
        );
        try {
            $response = $client->get("groups/" . $id , ['headers' => [
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

    public function projects( Request $request , $group )
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => env('GITLAB_API_URL'),
            'timeout'  => 5.0,
            ]
        );
        try {
            $response = $client->get("groups/" . $group . "/projects", ['headers' => [
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

    public function members( Request $request , $group )
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => env('GITLAB_API_URL'),
            'timeout'  => 5.0,
            ]
        );
        try {
            $response = $client->get("groups/" . $group . "/members", ['headers' => [
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

    public function member( Request $request , $group, $member )
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => env('GITLAB_API_URL'),
            'timeout'  => 5.0,
            ]
        );
        try {
            $response = $client->get("groups/" . $group . "/members" . "/" . $member, ['headers' => [
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

    public function deleteMember( Request $request , $group , $member )
    {
        $user = $request->user();
        $client = new Client([
            'base_uri' => env('GITLAB_API_URL'),
            'timeout'  => 5.0,
            ]
        );
        try {
            $response = $client->delete("groups/" . $group . "/members" . "/" . $member, ['headers' => [
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
