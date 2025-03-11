<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuario::factory(10)->create();

        $this->call(AccionSeeder::class);
        $this->call(RolesPermisosSeeder::class);
    }
}
