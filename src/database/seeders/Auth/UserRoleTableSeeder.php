<?php

namespace Database\Seeders\Auth;

use App\Models\Core\Auth\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class UserRoleTableSeeder.
 */
class UserRoleTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        $user = User::query()->find(1);
        if ($user) {
            $user->assignRole(config('access.users.app_admin_role'));
        }

        // manager
        $user = User::query()->find(2);
        if ($user) {
            $user->assignRole('Manager');
        }

        // agent
        $user = User::query()->find(3);
        if ($user) {
            $user->assignRole('Agent');
        }

        // client
        $user = User::query()->find(4);
        if ($user) {
            $user->assignRole('Client');
        }

        $this->enableForeignKeys();
    }
}
