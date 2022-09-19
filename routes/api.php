<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotUserController;
use App\Http\Controllers\PokemonController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1')->group(function () {
    Route::post('/register/chat-bot-user', [ChatbotUserController::class, 'registerUser']);
    Route::get('/users-chatbot', [ChatbotUserController::class, 'getUser']);
    Route::get('/pokemon/{name}', [PokemonController::class, 'getPokemon']);
});

Route::fallback(function () {
    return response()->json([
        'status'  => false,
        'message' => 'Request Not Found!',
        'data'    => null
    ], 404);
});
