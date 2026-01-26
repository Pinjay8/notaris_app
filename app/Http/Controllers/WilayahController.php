<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    public function provinsi()
    {
        $response = Http::get(
            'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json'
        );

        return response()->json($response->json());
    }

    public function kota($provinsi_id)
    {
        $response = Http::get(
            "https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinsi_id}.json"
        );

        return response()->json($response->json());
    }

    public function kecamatan($kota_id)
    {
        $response = Http::get(
            "https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$kota_id}.json"
        );

        return response()->json($response->json());
    }

    public function kelurahan($kecamatan_id)
    {
        $response = Http::get(
            "https://www.emsifa.com/api-wilayah-indonesia/api/villages/{$kecamatan_id}.json"
        );

        return response()->json($response->json());
    }
}
