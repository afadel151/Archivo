<?php

namespace Database\Seeders;

use App\Models\Schoolyear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;

class SchoolYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $data = [];
        for ($i=0; $i < 3; $i++) { 
            array_push($data,[
                'schoolyear' => fake()->unique()->randomElement(['2021/2022','2022/2023','2023/2024']),
            ]);
        }
        Schoolyear::insert($data);
 
    }
}
