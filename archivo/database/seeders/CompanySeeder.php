<?php

namespace Database\Seeders;

use App\Models\Battalion;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $battalions = Battalion::pluck('id')->toArray();
        for ($i=0; $i < 45; $i++) { 
            array_push($data,[
                'battalion_id'=> fake()->randomElement($battalions),
                'company' => $i%10,
                'sector' => fake()->randomElement(['MI','ST','PR']),
            ]);
        }

        Company::insert($data);
    }
}
