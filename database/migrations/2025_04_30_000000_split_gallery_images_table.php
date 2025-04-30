<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Buat tabel gallery_images
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')
                  ->constrained('galleries')
                  ->onDelete('cascade');
            $table->string('image'); // path image
            $table->timestamps();
        });

        // 2. Pindahkan data existing
        // ambil semua gallery yang punya image
        DB::table('galleries')
            ->select('id', 'image', 'created_at', 'updated_at')
            ->whereNotNull('image')
            ->where('image', '<>', '')
            ->orderBy('id')
            ->chunkById(100, function ($galleries) {
                $now = now();
                $inserts = [];
                foreach ($galleries as $g) {
                    $inserts[] = [
                        'gallery_id' => $g->id,
                        'image'      => $g->image,
                        'created_at' => $g->created_at ?? $now,
                        'updated_at' => $g->updated_at ?? $now,
                    ];
                }
                DB::table('gallery_images')->insert($inserts);
            });

        // 3. Hapus kolom image di tabel galleries
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Tambah kolom image kembali
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('image')->nullable()->after('title');
        });

        // 2. Kembalikan satu gambar (jika ada) ke kolom image
        //    (mengambil gambar pertama per gallery)
        DB::table('gallery_images')
            ->select('gallery_id', 'image')
            ->orderBy('id')
            ->chunkById(100, function ($rows) {
                foreach ($rows as $row) {
                    DB::table('galleries')
                        ->where('id', $row->gallery_id)
                        ->update(['image' => $row->image]);
                }
            });

        // 3. Drop tabel gallery_images
        Schema::dropIfExists('gallery_images');
    }
};
