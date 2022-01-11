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
