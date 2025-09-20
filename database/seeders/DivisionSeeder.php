<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now()->toDateTimeString();

        DB::table('divisions')->insert([
            ['id' => 1, 'name' => 'Human Resources', 'created_by' => 1, 'created_at' => $now, 'updated_by' => 1, 'updated_at' => $now, 'deleted' => false],
            ['id' => 2, 'name' => 'Finance', 'created_by' => 1, 'created_at' => $now, 'updated_by' => 1, 'updated_at' => $now, 'deleted' => false],
            ['id' => 3, 'name' => 'IT Department', 'created_by' => 1, 'created_at' => $now, 'updated_by' => 1, 'updated_at' => $now, 'deleted' => false],
        ]);
    }
}
