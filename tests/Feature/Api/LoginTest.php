<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Blog\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function loginValidUser()
    {
        // arrange
        $user = factory(User::class)->create();

        $loginData = [
            'email' => $user->email,
            'password' => 'secret'
        ];

        // act
        $response = $this->json('post', route('api.login'), $loginData);

        $response->assertStatus(200);

        $this->assertEquals(auth()->user()->email, $user->email);
    }
}
