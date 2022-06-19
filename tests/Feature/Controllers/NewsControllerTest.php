<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsControllerTest extends TestCase
{
    use RefreshDatabase;

    const STORE_JSON = [
        "title" => "any title",
        "content" => "any content"
    ];
    const UPDATE_JSON = [
        "title" => "new title",
        "content" => "new content"
    ];

    public function testStore()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user, 'sanctum')->postJson('/api/news', self::STORE_JSON);

        $response
            ->assertStatus(201)
            ->assertJsonStructure(['id']);
        $this
            ->assertDatabaseCount('news', 1)
            ->assertDatabaseHas('news', self::STORE_JSON);
    }

    public function testStoreUnauthorized()
    {
        $response = $this->postJson('/api/news', self::STORE_JSON);

        $response->assertStatus(401);
    }

    public function testUpdate()
    {
        $user = $this->createUserNews();

        $response = $this->actingAs($user, 'sanctum')->putJson('/api/news/1', self::UPDATE_JSON);

        $response->assertStatus(200);
        $this->assertDatabaseHas('news', self::UPDATE_JSON);
    }

    public function testUpdateForbidden()
    {
        $this->createUserNews();
        // Create another user
        $forbiddenUser = $this->createUser();

        $response = $this->actingAs($forbiddenUser, 'sanctum')->putJson('/api/news/1', self::UPDATE_JSON);

        $response->assertStatus(403);
    }

    public function testUpdateUnauthorized()
    {
        $this->createUserNews();

        $response = $this->putJson('/api/news/1', self::UPDATE_JSON);

        $response->assertStatus(401);
    }

    public function testDestroy()
    {
        $user = $this->createUserNews();

        $response = $this->actingAs($user, 'sanctum')->deleteJson('/api/news/1');

        $response
            ->assertStatus(200);
        $this
            ->assertDatabaseCount('news', 0);
    }

    public function testDestroyForbidden()
    {
        $this->createUserNews();
        // Create another user
        $forbiddenUser = $this->createUser();

        $response = $this->actingAs($forbiddenUser, 'sanctum')->deleteJson('/api/news/1');

        $response->assertStatus(403);
    }

    public function testDestroyUnauthorized()
    {
        $this->createUserNews();

        $response = $this->deleteJson('/api/news/1');

        $response->assertStatus(401);
    }

    public function testShow()
    {
        $user = $this->createUserNews();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/news/1');

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'title', 'content']);
    }

    public function testShowForbidden()
    {
        $this->createUserNews();
        // Create another user
        $forbiddenUser = $this->createUser();

        $response = $this->actingAs($forbiddenUser, 'sanctum')->getJson('/api/news/1');

        $response->assertStatus(403);
    }

    public function testShowUnauthorized()
    {
        $this->createUserNews();

        $response = $this->getJson('/api/news/1');

        $response->assertStatus(401);
    }

    public function testIndex()
    {
        $user = $this->createUserNews(5);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/news');

        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure(['data' => ['*' => ['id', 'title', 'content']]]);
    }


    public function testIndexForbidden()
    {
        $this->createUserNews(5);
        // Create another user
        $forbiddenUser = $this->createUser();

        $response = $this->actingAs($forbiddenUser, 'sanctum')->getJson('/api/news');

        $response
            ->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    public function testIndexUnauthorized()
    {
        $this->createUserNews();

        $response = $this->getJson('/api/news');

        $response->assertStatus(401);
    }

    private function createUser(): User
    {
        return User::factory()->create();
    }

    private function createUserNews(int $num = 1): User
    {
        return User::factory()
            ->hasNews($num)
            ->create();
    }
}
