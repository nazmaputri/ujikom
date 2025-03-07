<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            // Hapus constraint foreign key terlebih dahulu
            $table->dropForeign(['course_id']);
            // Hapus kolom course_id
            $table->dropColumn('course_id');
            // Tambahkan kolom purchase_id
            $table->foreignId('purchase_id')->nullable()->constrained()->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            // Hapus kolom purchase_id terlebih dahulu
            $table->dropForeign(['purchase_id']);
            $table->dropColumn('purchase_id');
    
            // Tambahkan kembali kolom course_id
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }
    
};
