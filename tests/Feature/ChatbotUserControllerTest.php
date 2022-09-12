<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChatbotUserControllerTest extends TestCase
{
    use WithFaker;

    /**
     * Testing method registerUser on controller Chatbot.
     * Skenario Success.
     *
     * @return void
     */
    public function test_registerUser_success()
    {
        $response = $this->post('/api/v1/register/chat-bot-user', [
            "name" => $this->faker->name()
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);

        $res = $response->decodeResponseJson();

        $this->assertEquals('User data has been saved', $res['message']);
    }
    
    /**
     * Testing method registerUser on controller Chatbot.
     * Skenario failled because name is required.
     *
     * @return void
     */
    public function test_registerUser_failled()
    {
        $response = $this->post('/api/v1/register/chat-bot-user', [], [
            'Accept' => 'application/json'
        ]);
        
        $response->assertStatus(400);

        $res = $response->decodeResponseJson();

        $this->assertEquals('Invalid request!', $res['message']);
    }
}
