<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create([
            'phone'=>'+998 71 205 84-84',
            'email'=>'info@realsoft.co',
            'address'=>'Ташкент, Малая кольцевая дорога, 38/1'
        ]);
    }
}
