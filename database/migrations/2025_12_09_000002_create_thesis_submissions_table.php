<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thesis_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('thesis_id'); // Skripsi yang disubmit
            $table->unsignedBigInteger('user_id'); // Mahasiswa yang submit
            $table->string('chapter'); // Bab (Bab 1, Bab 2, dst)
            $table->string('title'); // Judul bab
            $table->text('description')->nullable(); // Deskripsi/catatan submit
            $table->string('file_path'); // Path file yang diupload
            $table->enum('status', ['draft', 'submitted', 'reviewed', 'approved', 'rejected'])->default('draft');
            $table->integer('version')->default(1); // Versi bab
            $table->timestamps();

            // Foreign keys
            $table->foreign('thesis_id')->references('id')->on('thesis')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thesis_submissions');
    }
};
