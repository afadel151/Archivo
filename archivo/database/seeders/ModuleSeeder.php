<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i=0; $i < 300 ; $i++) { 
            array_push($data,
            [
                'module' => fake()->name(),
                'semester' => fake()->randomElement([1,2]),
                'battalion' => fake()->randomElement([1,2,3]),
                'sector' => fake()->randomElement(['MI','ST','PR']),
            ]);
        }
        Module::insert($data);
    }
}
