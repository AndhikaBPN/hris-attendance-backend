<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now()->toDateTimeString();

        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'Admin',
                'created_by' => 1,
                'created_at' => $now,
                'updated_by' => 1,
                'updated_at' => $now,
                'deleted' => false
            ],
            [
                'id' => 2,
                'name' => 'User',
                'created_by' => 1,
                'created_at' => $now,
                'updated_by' => 1,
                'updated_at' => $now,
                'deleted' => false
            ]
        ]);
    }
}
