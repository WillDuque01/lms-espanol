<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class InitialSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);

        $admin = User::firstOrCreate(
            ['email' => 'admin@lms.test'],
            ['name' => 'Admin', 'password' => bcrypt('admin1234')]
        );
        if (!$admin->hasRole('Admin')) {
            $admin->assignRole('Admin');
        }

        $this->call(DemoCourseSeeder::class);
        $this->call(DemoQuizSeeder::class);
    }
}
