<?php

namespace Tests\Feature\Commands;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteNewsCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteNews()
    {
        User::factory()
            ->hasNews(2, ['created_at' => now()->subDays(15)])
            ->hasNews(3)
            ->create();

        $this->artisan("news:delete --days=14")->assertSuccessful();
        $this->assertDatabaseCount('news', 3);
    }
}
