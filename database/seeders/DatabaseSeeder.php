<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name'      => 'Admin',
            'email'     => 'admin@gmail.com',
            'password'  => Hash::make('password'), 
            'role'      => 'admin',
            'status'    => 'active',
        ]);
        
        User::factory()->create([
            'name'      => 'Nazma',
            'email'     => 'nazma@gmail.com',
            'password'  => Hash::make('12345678'), 
            'role'      => 'student',
            'status'    => 'active',
        ]);

        User::factory()->create([
            'name'      => 'Intan',
            'email'     => 'aeni6746@gmail.com',
            'password'  => Hash::make('12345670'), 
            'role'      => 'mentor',
            'status'    => 'active',
        ]);

        // User::factory()->create([
        //     'name'      => 'Raib',
        //     'email'     => 'raib@gmail.com',
        //     'password'  => Hash::make('raibpacarali'), 
        //     'role'      => 'student',
        //     'status'    => 'active',
        // ]);

        // User::factory()->create([
        //     'name'      => 'ali',
        //     'email'     => 'ali@gmail.com',
        //     'password'  => Hash::make('alipacarintan'), 
        //     'role'      => 'student',
        //     'status'    => 'active',
        // ]);   
    }
}
