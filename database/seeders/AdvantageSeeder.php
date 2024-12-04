<?php

namespace Database\Seeders;

use App\Models\Advantage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdvantageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Advantage::create([
            'text'=>'Экспертиза и опыт',
            'image'=>'/images/Frame38368.svg',
        ]);
        Advantage::create([
            'text'=>'Контроль качества',
            'image'=>'/images/Frame38369.svg',
        ]);
        Advantage::create([
            'text'=>'Удовлетворенность клиентов',
            'image'=>'/images/Frame38370.svg',
        ]);
        Advantage::create([
            'text'=>'Современные технологии',
            'image'=>'/images/Frame38371.svg',
        ]);
        Advantage::create([
            'text'=>'Своевременная поставка',
            'image'=>'/images/Frame38372.svg',
        ]);
        Advantage::create([
            'text'=>'Индивидуальные решения',
            'image'=>'/images/Frame38373.svg',
        ]);
    }
}
