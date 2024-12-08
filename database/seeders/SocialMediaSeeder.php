<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SocialMedia::create([
            'name'=>'LinkedIn',
            'class'=>'fa-brands fa-linkedin',
            'url'=>'https://www.linkedin.com',
        ]);
        SocialMedia::create([
            'name'=>'Instagram',
            'class'=>'fa-brands fa-instagram',
            'url'=>'https://www.instagram.com',
        ]);
        SocialMedia::create([
            'name'=>'Telegram',
            'class'=>'fa-brands fa-telegram',
            'url'=>'https://telegram.org',
        ]);
        SocialMedia::create([
            'name'=>'YouTube',
            'class'=>'fa-brands fa-youtube',
            'url'=>'https://www.youtube.com',
        ]);
    }
}
