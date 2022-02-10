<?php

use GuzzleHttp\Client;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('gameapi/slp/details', function(Request $request) {
    $roninAddress = $request->ronin_address;
    $endpoint = "https://game-api.skymavis.com/game-api/clients/$roninAddress/items/1";
        $client = new Client();

        try {
            $request = $client->get($endpoint);
            $response = $request->getBody();

            return [
                'status' => 200,
                'data' => json_decode($response->getContents(), true)
            ];
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            throw new Exception('Failed Fetch API');
        }
});

Route::get('axie/battle-history', function(Request $request) {
    $baseUri = "https://tracking.skymavis.com/battle-history?type=pvp&player_id={RAW_ADDRESS}";
    $url = str_replace('{RAW_ADDRESS}', $request->ronin_address, $baseUri);
    $client = new \GuzzleHttp\Client();
    $headers = [
        'headers' => [
        'Accept' => 'application/json',
        ],
    ];
    try {
        $req = $client->get($url, $headers);
        $response = json_decode($req->getBody()->getContents(), true);
        if (isset($response['battles']) && isset($response['battles'])) {
            $battles = $response['battles'];
            return $battles;
        } else {
            return false;
        }
    } catch (\Throwable $th) {
        return false;
    }
});
