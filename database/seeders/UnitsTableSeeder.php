<?php

namespace Database\Seeders;

use App\Models\Dashboard\Utils\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'Grama', 'short_form' => 'g'],
            ['name' => 'Quilograma', 'short_form' => 'kg'],
            ['name' => 'Tonelada', 'short_form' => 't'],
            ['name' => 'Miligrama', 'short_form' => 'mg'],
            ['name' => 'Arroba', 'short_form' => '@'],

            ['name' => 'Mililitro', 'short_form' => 'mL'],
            ['name' => 'Litro', 'short_form' => 'L'],
            ['name' => 'Metro cúbico', 'short_form' => 'm³'],

            ['name' => 'Milímetro', 'short_form' => 'mm'],
            ['name' => 'Centímetro', 'short_form' => 'cm'],
            ['name' => 'Metro', 'short_form' => 'm'],
            ['name' => 'Quilômetro', 'short_form' => 'km'],

            ['name' => 'Metro quadrado', 'short_form' => 'm²'],
            ['name' => 'Hectare', 'short_form' => 'ha'],
            ['name' => 'Alqueire', 'short_form' => 'alq.'],

            ['name' => 'Quilowatt-hora', 'short_form' => 'kWh'],
        ];

        foreach ($units as $unit) {
            Unit::updateOrCreate(['short_form' => $unit['short_form']], $unit);
        }
    }
}
