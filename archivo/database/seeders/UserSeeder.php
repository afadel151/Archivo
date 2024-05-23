<?php

namespace Database\Seeders;

use App\Models\Section;
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
        $data = [];
        $sections = Section::pluck('id')->toArray();
        for ($i=0; $i < 300 ; $i++) { 
            array_push($data,
            [
                'name' => fake()->name(),
                'section_id' => fake()->randomElement($sections),
                'is_student' => fake()->boolean(80),
                'password' => Hash::make('12345678'),
                'email' => fake()->unique()->safeEmail(),
            ]);
        }

        User::insert($data);
    }
}
