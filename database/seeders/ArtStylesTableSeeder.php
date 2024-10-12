<?php

namespace Database\Seeders;

use App\Models\ArtStyle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtStylesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $artStyles = [
            'normal',
            'comic_book',
            'disney_toon',
            'studio_ghibli',
            'childrens_book',
            'photo_realism',
            'minecraft',
            'watercolor',
            'expressionism',
            'charcoal',
            'gtav',
            'anime',
            'normal_v2',
        ];

        foreach ($artStyles as $style) {
            ArtStyle::updateOrCreate(
                ['name' => $style],
                ['name' => $style]
            );
        }
    }
}
