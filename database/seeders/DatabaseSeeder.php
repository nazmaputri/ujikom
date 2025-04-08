<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RatingKursus;
use App\Models\Rating;
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
            'email'     => 'intanosaurusss@gmail.com',
            'password'  => Hash::make('intanosaurusss'), 
            'role'      => 'mentor',
            'status'    => 'inactive',
        ]);

        RatingKursus::create([
            'user_id' => 2,
            'course_id' => 2,
            'stars' => 2,
            'comment' => 'tes rating',
        ]);

        RatingKursus::create([
            'user_id' => 2,
            'course_id' => 2,
            'stars' => 2,
            'comment' => 'tes rating aja',
        ]);

        RatingKursus::create([
            'user_id' => 2,
            'course_id' => 2,
            'stars' => 2,
            'comment' => 'tes rating aja',
        ]);

        RatingKursus::create([
            'user_id' => 2,
            'course_id' => 2,
            'stars' => 2,
            'comment' => 'tes rating aja',
        ]);

        Rating::create([
            'nama' => 'intan',
            'email' => 'intan@gmail.com',
            'rating' => '3',
            'comment' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'
        ]);
    }
}
