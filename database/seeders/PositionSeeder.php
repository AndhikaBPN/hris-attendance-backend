<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now()->toDateTimeString();

        DB::table('positions')->insert([
            ['id' => 1, 'name' => 'Staff', 'created_by' => 1, 'created_at' => $now, 'updated_by' => 1, 'updated_at' => $now, 'deleted' => false],
            ['id' => 2, 'name' => 'Supervisor', 'created_by' => 1, 'created_at' => $now, 'updated_by' => 1, 'updated_at' => $now, 'deleted' => false],
            ['id' => 3, 'name' => 'Manager', 'created_by' => 1, 'created_at' => $now, 'updated_by' => 1, 'updated_at' => $now, 'deleted' => false],
            ['id' => 4, 'name' => 'Director', 'created_by' => 1, 'created_at' => $now, 'updated_by' => 1, 'updated_at' => $now, 'deleted' => false],
        ]);
    }
}
