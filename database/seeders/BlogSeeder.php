<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::create([
            'title'=>'«Toza Havo Sari»: в Ташкенте прошел IT ECO FEST 2024',
            'text'=>'В рамках весеннего фестиваля, который проходил два дня в Ташкентской области и Central Park...',
            'image'=>'/images/stati1.svg',
        ]);
        Blog::create([
            'title'=>'Раскрытие главных тенденций в SaaS: комплексное руководство',
            'text'=>'В постоянно развивающемся мире технологий программное обеспечение как услуга (SaaS) выд...',
            'image'=>'/images/stati2.svg',
        ]);
        Blog::create([
            'title'=>'RealSoft расширяется по всему Узбекистану!',
            'text'=>'В рамках исполнения постановления Президента Республики Узбекистан “О мерах по расширению охвата и п...',
            'image'=>'/images/stati3.svg',
        ]);
        Blog::create([
            'title'=>'RealSoft отмечает 23-летие инноваций и роста',
            'text'=>'Компания RealSoft была основана 12 февраля 2001 года в небольшой лаборатории в городе Бухара.',
            'image'=>'/images/stati4.svg',
        ]);
    }
}
