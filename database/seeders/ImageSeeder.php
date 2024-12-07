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
            'image'=>'/images/homepage-circle.svg',
            'type'=>'hero'
        ]);
        Image::create([
            'image'=>'/images/main-mini-circle.svg',
            'type'=>'hero'
        ]);
        Image::create([
            'image'=>'/images/kompaniya-realsoft.svg',
            'type'=>'company'
        ]);
        Image::create([
            'image'=>'/images/sngr-statistics-banner.png',
            'type'=>'statistic'
        ]);
        Image::create([
            'image'=>'/images/zayavku.png',
            'type'=>'form'
        ]);
    }
}
