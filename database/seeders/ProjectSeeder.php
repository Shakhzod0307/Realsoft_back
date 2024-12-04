<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::create([
            'title'=>'Оилакредит',
            'image'=>'/images/project1.svg',
        ]);
        Project::create([
            'title'=>'Навдаят боғча',
            'image'=>'/images/project2.svg',
        ]);
        Project::create([
            'title'=>'Green Pay',
            'image'=>'/images/project3.svg',
        ]);
        Project::create([
            'title'=>'Смарт Маркет',
            'image'=>'/images/project4.svg',
        ]);
        Project::create([
            'title'=>'Expert.uz',
            'image'=>'/images/project5.svg',
        ]);
        Project::create([
            'title'=>'EcoService',
            'image'=>'/images/project6.svg',
        ]);
    }
}
