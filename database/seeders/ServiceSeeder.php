<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'title'=>'На заказ',
            'text'=>'Мы предоставляем первоклассные решения в области разработки программного обеспечения на заказ.',
        ]);
        Service::create([
            'title'=>'Веб-разработка',
            'text'=>'Наши услуги по веб-разработке создают визуально привлекательные и адаптивные веб-сайты',
        ]);
        Service::create([
            'title'=>'Мобильных приложений',
            'text'=>'Мы поставляем интуитивно понятные и функциональные мобильные приложения',
        ]);
        Service::create([
            'title'=>'Фронтенд веб-приложений',
            'text'=>'Мы специализируемся на создании динамичных и интерактивных веб-приложений',
        ]);
        Service::create([
            'title'=>'Инжиниринг программных продуктов',
            'text'=>'Наши опытные инженеры превращают ваши идеи в надежные и масштабируемые программные продукты.',
        ]);
    }
}
