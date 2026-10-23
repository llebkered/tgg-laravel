<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    protected $signature = 'user:admin {email : The email address of the user}';

    protected $description = 'Give a user access to the admin';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->error('No user has the email address ' . $this->argument('email') . '.');

            return self::FAILURE;
        }

        $admin = Role::where('name', 'admin')->first();

        if (! $admin) {
            $this->error("There is no 'admin' role. Run php artisan migrate first.");

            return self::FAILURE;
        }

        $user->role()->associate($admin)->save();

        $this->info($user->name . ' (' . $user->email . ') can now use the admin.');

        return self::SUCCESS;
    }
}
