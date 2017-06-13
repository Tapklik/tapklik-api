<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Jwt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jwt:generate {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a valid JWT token for API authentication';

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
     * @return mixed
     */
    public function handle()
    {
        try {
            $user = User::where(['email' => $this->argument('email')])->firstOrFail();

            $this->info(User::apiToken($user));
        } catch (ModelNotFoundException $e) {
            $this->error('User with email ' . $this->argument('email') . ' was not found');
        }
    }
}
