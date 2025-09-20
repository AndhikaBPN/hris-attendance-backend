<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $now = Carbon::now()->toDateTimeString();

        $users = [];

        // 1 Admin
        $users[] = [
            'role_id' => 1, // Admin
            'division_id' => 1, // HR for example
            'position_id' => 4, // Director
            'manager_id' => null,
            'employee_card_id' => '0000000001',
            'first_name' => 'System',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('Admin@123'), // strong password
            'phone' => '08123456789',
            'address' => 'HQ Office',
            'photo' => null,
            'status' => 'active',
            'created_by' => 1,
            'created_at' => $now,
            'updated_by' => 1,
            'updated_at' => $now,
            'deleted' => false,
        ];

        // 19 Employees
        for ($i = 1; $i <= 19; $i++) {
            $users[] = [
                'role_id' => 2, // User
                'division_id' => $faker->numberBetween(1, 3),
                'position_id' => 1, // Staff
                'manager_id' => 1, // all employees report to admin
                'employee_card_id' => str_pad($i + 1, 10, '0', STR_PAD_LEFT),
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('Employee@123'),
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'photo' => null,
                'status' => 'active',
                'created_by' => 1,
                'created_at' => $now,
                'updated_by' => 1,
                'updated_at' => $now,
                'deleted' => false,
            ];
        }

        DB::table('users')->insert($users);
    }
}
