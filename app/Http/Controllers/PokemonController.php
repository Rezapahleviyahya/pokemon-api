<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public function getPokemon($name)
    {
        try {
            $response = Http::get('https://pokeapi.co/api/v2/pokemon/' . lcfirst($name));

            if (!$response->ok()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Pokemon info is not found',
                    'data'    => [
                        'info'    => "Sorry, we don't have any information about pokemon " . ucfirst($name),
                        'img'     => null,
                    ]
                ], 400);
            }

            $data = $response->json();
            $pokemon_name = ucfirst($data['name']);
            $info = "{$pokemon_name} is an {$data['types'][0]['type']['name']} with {$data['weight']} weight and {$data['height']} height, here's a picture of {$pokemon_name}";
            $img = $data['sprites']['other']['official-artwork']['front_default'];

            return response()->json([
                'status'  => true,
                'message' => 'Pokemon info is found',
                'data'    => [
                    'info'    => $info,
                    'img'     => $img,
                ]
            ], 200);
        } catch (Exception $e) {
            if (App::environment(['local', 'staging', 'testing'])) {
                return response()->json([
                    "error" => $e->getMessage(),
                    "data" => null
                ], 500);
            } else {
                Log::error($e->getMessage(), ['pokemon_name' => $name]);
                return response()->json([
                    "error" => "Something wrong",
                    "data" => null
                ], 500);
            }
        }
    }
}
