<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GalleriesTableSeeder extends Seeder
{
    public function run()
    {
        Gallery::create([
            'title' => 'Upacara Bendera',
            'image' => 'https://images.unsplash.com/photo-1627556704302-624286467c65',
            'date'  => '2024-03-01',
        ]);

        Gallery::create([
            'title' => 'Kegiatan Praktikum Sains',
            'image' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d',
            'date'  => '2024-03-05',
        ]);

        Gallery::create([
            'title' => 'Pertandingan Olahraga',
            'image' => 'https://images.unsplash.com/photo-1577471488278-16eec37ffcc2',
            'date'  => '2024-03-08',
        ]);
    }
}
