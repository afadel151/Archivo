<?php

namespace Database\Seeders;

use App\Models\Battalion;
use App\Models\Schoolyear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BattalionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $schoolyears = Schoolyear::pluck('id')->toArray();
        for ($i=0; $i < 3; $i++) { 
            array_push($data,[
                'schoolyear_id' => fake()->randomElement($schoolyears),
                'battalion' => fake()->randomElement([1,2,3]),
            ]);
        }
        Battalion::insert($data);
    }
}
