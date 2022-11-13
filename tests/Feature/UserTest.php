<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetUsers()
    {
        $users = User::factory()->count(2)->create();

        $user = User::factory()->create([
            'name' => "test Name",
            'email' => 'sample@test.com',
            'password' => bcrypt('sample123'),
            'role_id' => "2"
        ]);

        $token = JWTAuth::fromUser($user);


        $this->json('GET', 'api/users', [], ['Accept' => 'application/json', 'Authorization' => "Bearer" . $token])
            ->assertStatus(200)
            ->assertJsonStructure();

        $this->assertAuthenticated();
    }

    /**
     * @return void
     */
    public function testCreateUser()
    {
        $user = User::factory()->create([
            'name' => "test Name",
            'email' => fake()->email,
            'password' => bcrypt('sample123'),
            'role_id' => "2"
        ]);
        $token = JWTAuth::fromUser($user);

        $requestData = User::factory()->create()->toArray();
        $requestData["email"] = fake()->email;
        $requestData["password"] = Hash::make(123456);

        $this->json('POST', 'api/users', $requestData, ['Accept' => 'application/json', 'Authorization' => "Bearer" . $token])
            ->assertStatus(201);

        $this->assertAuthenticated();
    }

    /**
     * @return void
     */
    public function testUpdateUser()
    {
        $user = User::factory()->create([
            'name' => "test Name",
            'email' => fake()->email,
            'password' => bcrypt('sample123'),
            'role_id' => "2"
        ]);
        $token = JWTAuth::fromUser($user);

        $requestData["email"] = fake()->email;
        $requestData["password"] = Hash::make(123456);

        $this->json('PUT', 'api/users', $requestData, ['Accept' => 'application/json', 'Authorization' => "Bearer" . $token])
            ->assertStatus(200);

        $this->assertAuthenticated();
    }

    /**
     * @return void
     */
    public function testDeleteUser()
    {
        $user = User::factory()->create([
            'name' => "test Name",
            'email' => fake()->email,
            'password' => bcrypt('sample123'),
            'role_id' => "2"
        ]);
        $token = JWTAuth::fromUser($user);
        $this->json('DELETE', 'api/users/' . $user->id , [], ['Accept' => 'application/json', 'Authorization' => "Bearer" . $token])
            ->assertStatus(200);

        $this->assertAuthenticated();
    }
}
