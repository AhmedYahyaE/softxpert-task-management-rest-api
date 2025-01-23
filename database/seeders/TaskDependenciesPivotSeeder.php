<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskDependenciesPivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('task_dependencies_pivot')->insert([
            [
                'task_id'       => 5,
                'dependency_id' => 2,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'task_id'       => 5,
                'dependency_id' => 3,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'task_id'       => 5,
                'dependency_id' => 4,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'task_id'       => 2,
                'dependency_id' => 3,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'task_id'       => 2,
                'dependency_id' => 6,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'task_id'       => 7,
                'dependency_id' => 4,
                'created_at'    => now(),
                'updated_at'    => now()
            ]
        ]);
    }
}
