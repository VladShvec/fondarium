<?php

namespace Database\Seeders\Auto;

use App\Models\Auto;
use Illuminate\Database\Seeder;

class AutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Auto::factory()->count(10)->create();
    }
}
