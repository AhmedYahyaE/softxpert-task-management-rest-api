<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $randomTaskName = fake()->word();

            $task = Task::create([
                'user_id'     => rand(3, 5), // 'user' role users ids
                'created_by'  => rand(1, 2), // 'manager' role users ids
                'title'       => $randomTaskName,
                'description' => fake()->sentence(10),
                'status'      => 'pending',
                'due_date'    => now()->addDays(rand(1, 30))
            ]);
        }
    }
}
