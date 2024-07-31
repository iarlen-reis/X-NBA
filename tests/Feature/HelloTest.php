<?php

namespace Tests\Feature;

use Tests\TestCase;

class HelloTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_if_return_an_json_with_key_message_and_value_hello_word(): void
    {
        $request = $this->get('/api/hello');

        $request->assertJson([
            'message' => 'Hello World!',
        ]);
    }

    public function test_if_return_status_code_200(): void
    {
        $request = $this->get('/api/hello');

        $request->assertStatus(200);
    }
}
