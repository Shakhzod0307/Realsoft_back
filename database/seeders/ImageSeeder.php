<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Image::create([
            'name'=>'/images/homepage-circle.svg',
            'type'=>'hero'
        ]);
        Image::create([
            'name'=>'/images/main-mini-circle.svg',
            'type'=>'hero'
        ]);
        Image::create([
            'name'=>'/images/kompaniya-realsoft.svg',
            'type'=>'company'
        ]);
        Image::create([
            'name'=>'/images/sngr-statistics-banner.png',
            'type'=>'statistic'
        ]);
        Image::create([
            'name'=>'/images/zayavku.png',
            'type'=>'form'
        ]);
    }
}
