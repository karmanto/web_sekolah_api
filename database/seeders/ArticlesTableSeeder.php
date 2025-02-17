<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticlesTableSeeder extends Seeder
{
    public function run()
    {
        Article::create([
            'title'   => 'Prestasi Gemilang Tim Robotik',
            'content' => 'Tim robotik sekolah kita berhasil meraih juara pertama dalam kompetisi nasional. Prestasi ini merupakan hasil kerja keras dan dedikasi tim selama berbulan-bulan persiapan. Kompetisi yang diikuti melibatkan lebih dari 50 sekolah dari seluruh Indonesia.',
            'image'   => 'https://images.unsplash.com/photo-1589652717521-10c0d092dea9',
            'date'    => '2024-03-10',
            'author'  => 'Admin',
        ]);

        Article::create([
            'title'   => 'Program Literasi Digital',
            'content' => 'Sekolah kita meluncurkan program literasi digital untuk meningkatkan kemampuan siswa dalam menggunakan teknologi secara bertanggung jawab. Program ini mencakup pelatihan keamanan online, etika digital, dan penggunaan produktif teknologi.',
            'image'   => 'https://images.unsplash.com/photo-1509062522246-3755977927d7',
            'date'    => '2024-03-08',
            'author'  => 'Tim IT',
        ]);
    }
}
