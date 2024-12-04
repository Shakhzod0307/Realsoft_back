<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Statistic::create([
            'image'=>'/images/blueprint.svg',
            'number'=>'260+',
            'title'=>'Реализованные проекты',
        ]);
        Statistic::create([
            'image'=>'/images/chart-histogram.svg',
            'number'=>'150%',
            'title'=>'Среднегодовой темп роста',
        ]);
        Statistic::create([
            'image'=>'/images/admin-alt.svg',
            'number'=>'200+',
            'title'=>'Специалисты',
        ]);
        Statistic::create([
            'image'=>'/images/ranking-stars.svg',
            'number'=>'23+',
            'title'=>'Годы уникального опыта',
        ]);
    }
}
