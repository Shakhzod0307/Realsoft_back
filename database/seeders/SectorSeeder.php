<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sector::create([
            'title'=>'Государство и общественный сектор',
            'text'=>'Наши опытные инженеры преобразуют ваши идеи в надежные и масштабируемые программные продукты.',
            'image'=>'/images/building.svg'
        ]);
        Sector::create([
            'title'=>'Телекоммуникации',
            'text'=>'Наши опытные инженеры преобразуют ваши идеи в надежные и масштабируемые программные продукты.',
            'image'=>'/images/broadcast-tower.svg'
        ]);
        Sector::create([
            'title'=>'Сельское хозяйство',
            'text'=>'Наши опытные инженеры преобразуют ваши идеи в надежные и масштабируемые программные продукты.',
            'image'=>'/images/farm.svg'
        ]);
        Sector::create([
            'title'=>'Финансы и банковское дело',
            'text'=>'Наши опытные инженеры преобразуют ваши идеи в надежные и масштабируемые программные продукты.',
            'image'=>'/images/bank.svg'
        ]);
        Sector::create([
            'title'=>'Здравоохранение',
            'text'=>'Наши опытные инженеры преобразуют ваши идеи в надежные и масштабируемые программные продукты.',
            'image'=>'/images/doctor.svg'
        ]);
        Sector::create([
            'title'=>'Электронная коммерция и розничная торговля',
            'text'=>'Наши опытные инженеры преобразуют ваши идеи в надежные и масштабируемые программные продукты.',
            'image'=>'/images/shopping-cart.svg'
        ]);
        Sector::create([
            'title'=>'Логистика и цепочка поставок',
            'text'=>'Наши опытные инженеры преобразуют ваши идеи в надежные и масштабируемые программные продукты.',
            'image'=>'/images/truck-side.svg'
        ]);
        Sector::create([
            'title'=>'Образование',
            'text'=>'Наши опытные инженеры преобразуют ваши идеи в надежные и масштабируемые программные продукты.',
            'image'=>'/images/book-alt.svg'
        ]);
    }
}
