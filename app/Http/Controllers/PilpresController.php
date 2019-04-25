<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use \GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Client;

class PilpresController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function coba()
    {
        return view('kpu');
        # code...
    }

    public function api(Request $request)
    {
        $client = new Client(['verify' => false]); //GuzzleHttp\Client
        try {
            // $key = '5c99ce41e70a1e6ff09fca83580020a0';
            $headers = [
                'Accept' => 'application/json',
            ];
            $result = $client->request('GET','https://pemilu2019.kpu.go.id/static/json/hhcw/ppwp.json' ,[
                'headers' => $headers
            ]);
            $final = json_decode($result->getBody()->getContents(),true);
            for($i=0; $i<count($final['chart']);$i++) {
                $prabowo = $final['chart']['22'];
                $jokowi = $final['chart']['21'];
                return response()->json([
                    'jokowi' => $jokowi,
                    'prabowo' => $prabowo
                ],200);
            } 
        } catch(BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = $response->getBody();
            return response()->json(json_decode($jsonBody),$response->getStatusCode());
        }
        # code...
    }

    public function proggress(Request $request)
    {
        $client = new Client(['verify' => false]); //GuzzleHttp\Client
        try {
            // $key = '5c99ce41e70a1e6ff09fca83580020a0';
            $headers = [
                'Accept' => 'application/json',
            ];
            $result = $client->request('GET','https://pemilu2019.kpu.go.id/static/json/hhcw/ppwp.json' ,[
                'headers' => $headers
            ]);
            $final = json_decode($result->getBody()->getContents(),true);
            for($i=0; $i<count($final['progress']);$i++) {
                $total = $final['progress']['total'];
                $proses = $final['progress']['proses'];
        
                return response()->json([
                    'total' => $total,
                    'prosses' => $proses
                ],200);
            }
        } catch(BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = $response->getBody();
            return response()->json(json_decode($jsonBody),$response->getStatusCode());
        }
    }
}
