<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PokemonControllerTest extends TestCase
{
    /**
     * Testing method getPokemon on controller Chatbot.
     * Skenario Success.
     *
     * @return void
     */
    public function test_getPokemon_success()
    {
        // Get by name
        $response = $this->get('/api/v1/pokemon/pikachu', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);

        $res = $response->decodeResponseJson();

        $this->assertEquals('Pokemon info is found', $res['message']);

        // Get by id
        $response = $this->get('/api/v1/pokemon/1', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);

        $res = $response->decodeResponseJson();

        $this->assertEquals('Pokemon info is found', $res['message']);

        // Get by name with camel case
        $response = $this->get('/api/v1/pokemon/Pikachu', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);

        $res = $response->decodeResponseJson();

        $this->assertEquals('Pokemon info is found', $res['message']);
    }

    /**
     * Testing method getPokemon on controller Chatbot.
     * Skenario failled
     *
     * @return void
     */
    public function test_getPokemon_failled()
    {
        // Name not found
        $response = $this->get('/api/v1/pokemon/pikachuu', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(400);

        $res = $response->decodeResponseJson();

        $this->assertEquals('Pokemon info is not found', $res['message']);

        // Id not found
        $response = $this->get('/api/v1/pokemon/100000', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(400);

        $res = $response->decodeResponseJson();

        $this->assertEquals('Pokemon info is not found', $res['message']);

        // Name is weird
        $response = $this->get('/api/v1/pokemon/pikAChu', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(400);

        $res = $response->decodeResponseJson();

        $this->assertEquals('Pokemon info is not found', $res['message']);
    }
}
