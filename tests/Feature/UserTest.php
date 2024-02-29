<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response =[
            'email' => 'nami@gmail.com',
            'password' => '12345678',
        ];

        $res = $this->get('/login', $response);

        $res->assertStatus(200);
    }
}
