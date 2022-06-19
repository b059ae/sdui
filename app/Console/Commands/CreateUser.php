<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Insert Admin
        $user = User::create([
            'name' => $email,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make($password),
        ]);
        $token = $user->createToken('authToken')->plainTextToken;

        $this->info("User successfully created");
        $this->info("Auth token: {$token}");
        return 0;
    }
}
