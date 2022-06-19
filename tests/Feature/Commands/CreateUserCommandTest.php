<?php

namespace Tests\Feature\Commands;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateUser()
    {
        $email = 'user@foo.com';
        $password = 'password';

        $this->artisan("create:user $email $password")->assertSuccessful();
        $user = User::where('email', $email)->firstOrFail();

        $this->assertEquals($email, $user->email);
        $this->assertDatabaseCount('personal_access_tokens', 1);
    }
}
