<?php

namespace Tests\Feature;

use App\Models\User;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessfulLogin()
    {
        $user = User::factory()->create([
            'name' => "test Name",
            'email' => 'sample@test.com',
            'password' => bcrypt('sample123'),
            'role_id' => "2"
        ]);

        $loginData = ['email' => 'sample@test.com', 'password' => 'sample123'];
        $this->json('GET', 'api/auth/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "access_token",
                "token_type",
                "expires_in"
            ]);

        $this->assertAuthenticated();
    }

    /**
     * @return void
     */
    public function testSuccessfulLogout()
    {
        $user = User::factory()->create([
            'name' => "test Name",
            'email' => 'sample@test.com',
            'password' => bcrypt('sample123'),
            'role_id' => "2"
        ]);

        $token = JWTAuth::fromUser($user);

        $this->json('POST', 'api/auth/logout', [], ['Accept' => 'application/json', 'Authorization' => "Bearer" . $token])
                ->assertStatus(200)
                ->assertJsonStructure([
                    "message"
                ]);
    }

    /**
     * @return void
     */
    public function testSuccessfulLoginUser()
    {
        $user = User::factory()->create([
            'name' => "test Name",
            'email' => 'sample@test.com',
            'password' => bcrypt('sample123'),
            'role_id' => "2"
        ]);

        $token = JWTAuth::fromUser($user);

        $this->json('POST', 'api/auth/me', [], ['Accept' => 'application/json', 'Authorization' => "Bearer" . $token])
            ->assertStatus(200)
            ->assertJsonStructure([

            ]);

        $this->assertAuthenticated();
    }

    public function testRefreshToken()
    {
        $user = User::factory()->create([
            'name' => "test Name",
            'email' => 'sample@test.com',
            'password' => bcrypt('sample123'),
            'role_id' => "2"
        ]);

        $token = JWTAuth::fromUser($user);

        $loginData = ['email' => 'sample@test.com', 'password' => 'sample123'];
        $this->json('POST', 'api/auth/refresh', $loginData, ['Accept' => 'application/json', 'Authorization' => "Bearer" . $token])
            ->assertStatus(200)
            ->assertJsonStructure([
                "access_token",
                "token_type",
                "expires_in"
            ]);

        $this->assertAuthenticated();
    }
}
