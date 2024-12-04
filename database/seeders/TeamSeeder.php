<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'name'=>'Хикматулло Насруллаев',
                'position'=>'Генеральный директор',
                'image'=>'/images/komanda1.svg',
                'type'=>'full'
            ],
            [
                'name'=>'Хаётжон Насруллоев',
                'position'=>'Исполнительный директор',
                'image'=>'/images/komanda2.svg',
                'type'=>'full'
            ],
            [
                'name'=>'Жўра Мавлонов',
                'position'=>'Советник генерального директора',
                'image'=>'/images/komanda3.svg',
                'type'=>'full'
            ],
            [
                'name'=>'Фаррух Ахмедов',
                'position'=>'Операционный директор',
                'image'=>'/images/komanda4.svg',
                'type'=>'full'
            ],
            [
                'name'=>'Лазизбек Парманов',
                'position'=>'Коммерческий директор',
                'image'=>'/images/komanda5.svg',
                'type'=>'full'
            ],
            [
                'image'=>'/images/komanda7.svg',
                'type'=>'only-image'
            ],
            [
                'image'=>'/images/komanda8.svg',
                'type'=>'only-image'
            ],
            [
                'image'=>'/images/komanda9.svg',
                'type'=>'only-image'
            ],
            [
                'image'=>'/images/komanda10.svg',
                'type'=>'only-image'
            ],
            [
                'image'=>'/images/komanda11.svg',
                'type'=>'only-image'
            ],
            [
                'image'=>'/images/komanda12.svg',
                'type'=>'only-image'
            ],
            [
                'image'=>'/images/komanda13.svg',
                'type'=>'only-image'
            ],
            [
                'image'=>'/images/komanda14.svg',
                'type'=>'only-image'
            ],
            [
                'image'=>'/images/komanda15.svg',
                'type'=>'only-image'
            ]
        ];
        foreach ($teams as $member) {
            Team::create($member);
        }

    }
}
