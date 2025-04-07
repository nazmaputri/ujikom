<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // UNTUK MENAMBAHKAN STATUS NOPUBLISHED AGAR BISA MENGHIDDEN KURSUS DI LANDINGPAGE (fitur hidden kursus yang ada di halaman category-detail role admin)
    public function up()
    {
        DB::statement("ALTER TABLE courses MODIFY status ENUM('pending', 'approved', 'published', 'nopublished') DEFAULT 'pending'");
    }

    public function down()
    {
        // Kembalikan ke enum sebelumnya (jika mau)
        DB::statement("ALTER TABLE courses MODIFY status ENUM('pending', 'approved', 'published') DEFAULT 'pending'");
    }
};
