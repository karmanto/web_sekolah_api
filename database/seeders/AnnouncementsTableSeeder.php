<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;

class AnnouncementsTableSeeder extends Seeder
{
    public function run()
    {
        Announcement::create([
            'title'    => 'Pendaftaran Siswa Baru 2024/2025',
            'content'  => 'Pendaftaran siswa baru tahun ajaran 2024/2025 telah dibuka. Orang tua calon siswa dapat mendaftar secara online melalui website sekolah atau datang langsung ke sekretariat PPDB.',
            'date'     => '2024-03-15',
            'important'=> true,
        ]);

        Announcement::create([
            'title'    => 'Jadwal Ujian Tengah Semester',
            'content'  => 'Ujian Tengah Semester akan dilaksanakan mulai tanggal 20 Maret 2024. Siswa diharapkan mempersiapkan diri dengan baik.',
            'date'     => '2024-03-13',
            'important'=> false,
        ]);
    }
}
