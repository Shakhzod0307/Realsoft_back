<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Types\Relations\Part;


class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Partner::create([
            'image'=>'/images/agrobank2.svg',
        ]);
        Partner::create([
            'image'=>'/images/brb1.svg',
        ]);
        Partner::create([
            'image'=>'/images/mkbank.svg',
        ]);
        Partner::create([
            'image'=>'/images/ofb.svg',
        ]);
        Partner::create([
            'image'=>'/images/sqb.svg',
        ]);
        Partner::create([
            'image'=>'/images/xalqbank.svg',
        ]);
        Partner::create([
            'image'=>'/images/maktab-talim.svg',
        ]);
        Partner::create([
            'image'=>'/images/markaziybank.svg',
        ]);

    }
}
