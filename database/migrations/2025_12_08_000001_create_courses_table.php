<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Mata Kuliah
            $table->string('code')->unique(); // Kode MK (misal: IS101)
            $table->string('icon')->nullable(); // Emoji icon untuk UI
            $table->unsignedBigInteger('lecturer_id'); // ID dosen pengampu
            $table->text('description')->nullable(); // Deskripsi mata kuliah
            $table->string('semester')->nullable(); // Semester (misal: Ganjil 2024)
            $table->integer('credits')->nullable(); // SKS
            $table->timestamps();

            // Foreign key relationship
            $table->foreign('lecturer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
