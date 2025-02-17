<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventsTableSeeder extends Seeder
{
    public function run()
    {
        Event::create([
            'title'       => 'Perayaan Hari Pendidikan Nasional',
            'date'        => '2024-05-02',
            'location'    => 'Aula Sekolah',
            'description' => 'Acara peringatan Hari Pendidikan Nasional dengan berbagai lomba dan penampilan dari siswa-siswi. Akan ada pameran karya siswa dan pentas seni.',
        ]);

        Event::create([
            'title'       => 'Seminar Pendidikan Karakter',
            'date'        => '2024-04-15',
            'location'    => 'Ruang Multimedia',
            'description' => 'Seminar tentang pentingnya pendidikan karakter dalam membentuk generasi muda yang berintegritas dan bertanggung jawab.',
        ]);
    }
}
