<?php

namespace Database\Seeders;

use Database\Seeders\Auto\AutoSeeder;
use Database\Seeders\Role\RoleSeeder;
use Database\Seeders\User\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            AutoSeeder::class
        ]);
    }
}
