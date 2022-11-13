<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class CarTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetCars()
    {
        $user = User::factory()->create([
            'name' => "test Name",
            'email' => 'sample@test.com',
            'password' => bcrypt('sample123'),
            'role_id' => "2"
        ]);

        $token = JWTAuth::fromUser($user);


        $this->json('GET', 'api/autos', [], ['Accept' => 'application/json', 'Authorization' => "Bearer" . $token])
            ->assertStatus(200)
            ->assertJsonStructure();

        $this->assertAuthenticated();
    }
}
