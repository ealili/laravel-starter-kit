<?php

namespace Database\Seeders;

use App\Models\Role;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        // User::factory(10)->create();

        DB::table('users')->insert([
            'name' => 'Enes Alili',
            'email' => 'e@mail.com',
            'password' => bcrypt('password'),
            'role_id' => Role::IS_USER
        ]);
    }
}
