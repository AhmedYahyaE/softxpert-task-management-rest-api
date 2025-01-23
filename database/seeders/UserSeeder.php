<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 'manager' role users
        $managerOne =  User::create([
            'name' => 'Ahmed Yahya',
            'email' => 'ahmed.yahya@email.com',
            'password' => Hash::make('123456'),
        ]);

        // Assign 'manager' role to the user
        $managerOne->assignRole('manager');

        $managerTwo =  User::create([
            'name' => 'Farouk Azzam',
            'email' => 'farouk.azzam@email.com',
            'password' => Hash::make('123456'),
        ]);

        // Assign 'manager' role to the user
        $managerTwo->assignRole('manager');



        // Create 'user' role users
        for ($i = 0; $i < 3; $i++) {
            $randomUserName = fake()->name();

            $user = User::create([
                'name'     => $randomUserName,
                'email'    => str_replace(' ', '.', $randomUserName) . '@email.com',
                'password' => Hash::make('123456')
            ]);

            // Assign 'user' role to the user
            $user->assignRole('user');
        }

    }
}
