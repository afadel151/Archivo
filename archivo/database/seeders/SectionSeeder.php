<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $companies = Company::pluck('id')->toArray();
        for ($i=0; $i < 135; $i++) { 
            array_push($data,
                [
                    'section' => $i%4,
                    'company_id' => fake()->randomElement($companies),
                ]
            );
        }
        Section::insert($data);
    }
}
