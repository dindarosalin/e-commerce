<?php

namespace App\Http\Controllers\Shipping;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ShippingController extends Controller
{
    public function index(Request $request) {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8080/fee';

        try {
            $response = $client->get($apiUrl);
            
            $data = json_decode($response->getBody(), true);

            return view('checkout.index', ['fetchProvince' => $data]);
        } catch (\Throwable $th) {
            return view('api_error', ['error' => $th->getMessage()]);
        }
        
    }
}
