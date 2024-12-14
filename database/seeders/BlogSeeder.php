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
            'title' => json_encode([
                'en' => '“Towards Clean Air”: IT ECO FEST 2024 held in Tashkent',
                'uz' => '«Toza Havo Sari»: Toshkentda IT ECO FEST 2024 bo‘lib o‘tdi',
                'ru' => '«Свежий воздух желтый»: в Ташкенте прошел IT ECO FEST 2024',
            ]),
            'text' => json_encode([
                'en' => 'During the spring festival, which took place over two days in Tashkent region and Central Park...',
                'uz' => 'Toshkent viloyati va Central Parkda ikki kun davomida bo‘lib o‘tgan bahorgi festival davomida...',
                'ru' => 'В рамках весеннего фестиваля, который проходил два дня в Ташкентской области и Central Park...',
            ]),
            'images' => json_encode([
                ['url' => '/images/stati1.svg', 'index' => 1],
            ]),
        ]);

        Blog::create([
            'title' => json_encode([
                'en' => 'Unveiling Key Trends in SaaS: A Comprehensive Guide',
                'uz' => 'SaaS sohasidagi asosiy tendensiyalarni ochib berish: To‘liq qo‘llanma',
                'ru' => 'Раскрытие главных тенденций в SaaS: комплексное руководство',
            ]),
            'text' => json_encode([
                'en' => 'In the ever-evolving world of technology, Software as a Service (SaaS) has emerged as a dominant...',
                'uz' => 'Tez rivojlanayotgan texnologiya dunyosida xizmat sifatida dasturiy ta’minot (SaaS) yetakchi sifatida...',
                'ru' => 'В постоянно развивающемся мире технологий программное обеспечение как услуга (SaaS) выд...',
            ]),
            'images' => json_encode([
                ['url' => '/images/stati2.svg', 'index' => 1],
            ]),
        ]);

        Blog::create([
            'title' => json_encode([
                'en' => 'RealSoft Expands Across Uzbekistan!',
                'uz' => 'RealSoft O‘zbekiston bo‘ylab kengaymoqda!',
                'ru' => 'RealSoft расширяется по всему Узбекистану!',
            ]),
            'text' => json_encode([
                'en' => 'As part of the implementation of the Presidential decree of the Republic of Uzbekistan “On measures...',
                'uz' => 'O‘zbekiston Respublikasi Prezidentining “Qamrovni kengaytirish choralari to‘g‘risida”gi qarorini...',
                'ru' => 'В рамках исполнения постановления Президента Республики Узбекистан “О мерах по расширению охвата...',
            ]),
            'images' => json_encode([
                ['url' => '/images/stati3.svg', 'index' => 1],
            ]),
        ]);

        Blog::create([
            'title' => json_encode([
                'en' => 'RealSoft Celebrates 23 Years of Innovation and Growth',
                'uz' => 'RealSoft innovatsiyalar va o‘sishning 23 yilligini nishonlamoqda',
                'ru' => 'RealSoft отмечает 23-летие инноваций и роста',
            ]),
            'text' => json_encode([
                'en' => 'RealSoft was founded on February 12, 2001, in a small laboratory in the city of Bukhara.',
                'uz' => 'RealSoft 2001 yil 12 fevralda Buxoro shahrida kichik laboratoriyada tashkil etilgan.',
                'ru' => 'Компания RealSoft была основана 12 февраля 2001 года в небольшой лаборатории в городе Бухара.',
            ]),
            'images' => json_encode([
                ['url' => '/images/stati4.svg', 'index' => 1],
            ]),
        ]);
    }
}
