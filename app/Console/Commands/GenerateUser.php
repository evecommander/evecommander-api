<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GenerateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a user in order to run tests with external tools such as Postman.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function handle()
    {
        $password = bin2hex(random_bytes(16));

        /** @var User $user */
        $user = factory(User::class)->create(['password' => Hash::make($password)]);

        $row = [
            (string) $user->id,
            $user->email,
            $password,
            $user->created_at,
            $user->updated_at,
        ];

        $this->table(['id', 'email', 'password', 'created_at', 'updated_at'], [$row]);
    }
}
